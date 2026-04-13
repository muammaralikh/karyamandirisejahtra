<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
    public function proses_login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (
            Auth::attempt([
                'username' => $request->username,
                'password' => $request->password,
                'status' => 'Aktif',
            ])
        ) {

            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'admin' => redirect()->route('admin.dashboard')->with('success', 'Berhasil Login'),
                'user' => redirect()->route('user.dashboard')->with('success','Berhasil Login'),
                default => tap(
                    Auth::logout(),
                    fn() =>
                    back()->with('error', 'Role tidak dikenali')
                ),
            };
        }

        return back()->with('error', 'Username atau Password salah');
    }
    public function proses_register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'user',
            'status'   => 'Aktif',
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat. Silakan login');
    }
      public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/login')->with('success', 'Berhasil logout');
    }

}