<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(string $token, Request $request)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function proses_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        $user = User::where('email', $request->email)->first();

        if (
            $user &&
            Hash::check($request->password, $user->password) &&
            $this->canUserLogin($user)
        ) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return match (strtolower((string) Auth::user()->role)) {
                'admin' => redirect()->route('admin.dashboard')->with('success', 'Berhasil Login'),
                'user' => redirect()->route('user.dashboard')->with('success', 'Berhasil Login'),
                default => tap(
                    Auth::logout(),
                    fn() => back()->with('error', 'Role tidak dikenali')
                ),
            };
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password salah');
    }

    public function proses_register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'nullable|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->filled('username')
                ? $request->username
                : $this->generateUsernameFromEmail($request->email),
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'Aktif',
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat. Silakan login');
    }

    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Link reset password belum bisa dikirim saat ini. Silakan coba lagi beberapa saat lagi.');
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', $this->translatePasswordStatus($status))
            : back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => $this->translatePasswordStatus($status)]);
    }

    public function proses_reset_password(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Password baru belum bisa disimpan saat ini. Silakan coba lagi beberapa saat lagi.');
        }

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', $this->translatePasswordStatus($status))
            : back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => [$this->translatePasswordStatus($status)]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout');
    }

    private function generateUsernameFromEmail(string $email): string
    {
        $base = Str::slug(Str::before($email, '@'), '_');
        $base = $base !== '' ? $base : 'user';
        $username = $base;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . '_' . $counter;
            $counter++;
        }

        return $username;
    }

    private function canUserLogin(User $user): bool
    {
        if (!Schema::hasColumn($user->getTable(), 'status')) {
            return true;
        }

        $status = trim((string) $user->status);

        if ($status === '') {
            return true;
        }

        return strcasecmp($status, 'Aktif') === 0;
    }

    private function translatePasswordStatus(string $status): string
    {
        return match ($status) {
            Password::RESET_LINK_SENT => 'Link reset password berhasil dikirim ke email Anda.',
            Password::PASSWORD_RESET => 'Password berhasil diperbarui. Silakan login dengan password baru.',
            Password::INVALID_USER => 'Email tersebut belum terdaftar di sistem.',
            Password::INVALID_TOKEN => 'Link reset password tidak valid atau sudah kedaluwarsa.',
            Password::RESET_THROTTLED => 'Permintaan reset terlalu sering. Silakan tunggu sebentar lalu coba lagi.',
            default => 'Terjadi kendala pada proses reset password. Silakan coba lagi.',
        };
    }
}
