<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\GeneratesUniqueUsername;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use GeneratesUniqueUsername;

    private function setActive($page)
    {
        return [
            'activeUser' => $page,
            'userActive' => true,
        ];
    }
    public function daftar(Request $request)
    {
        $query = User::withCount(['orders'])
            ->orderBy('created_at', 'desc');
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $users = $query->paginate(10);

        return view('admin.pages.akun', compact(
            'users',
            'totalUsers',
            'adminCount'
        ), $this->setActive('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'role' => 'required|in:admin,user',
        ]);

        try {
            $validated['username'] = $validated['username'] ?? $this->generateUniqueUsernameFromEmail($validated['email'], $user->id);

            $user->update($validated);
            return redirect()->route('daftar-user.index')
                ->with('success', 'Pengguna berhasil diperbarui');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id == auth()->id()) {
            return redirect()->route('daftar-user.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        }

        try {
            $user->delete();

            return redirect()->route('daftar-user.index')
                ->with('success', 'Pengguna berhasil dihapus');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'nullable|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username ?: $this->generateUniqueUsernameFromEmail($request->email),
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'Aktif',
        ]);

        return back()->with('success', 'Akun berhasil ditambah');
    }


}
