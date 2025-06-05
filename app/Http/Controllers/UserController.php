<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|in:admin,manajer',
    ], [
        'username.unique' => 'Username sudah terdaftar. Silakan gunakan username lain.',
        'password.min' => 'Password harus memiliki minimal 8 karakter.',
        'role.in' => 'Role yang dipilih tidak valid.',
    ]);

    User::create([
        'username' => $request->username,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
}

     public function redirectUser()
{
    if (auth()->check()) {
        $user = auth()->user();

        if ($user->role == 'admin') {
            return redirect()->route('index');
        } elseif ($user->role == 'manajer') {
            return redirect()->route('manajer.dashboard');
        }
    }
    
    return redirect()->route('index'); // Jika user tidak login atau role lain, kembali ke halaman utama
}

public function showUser () {
    $user = User::all();

    return view('manajer.data-user', compact('user'));
}
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
}
public function resetPassword(Request $request)
{
    // Validasi input
    $request->validate([
        'username' => 'required|exists:users,username',
        'new_password' => 'required|min:8|confirmed',
    ], [
        'new_password.min' => 'Password harus minimal 8 karakter.',
        'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);

    // Cari user berdasarkan username
    $user = User::where('username', $request->username)->first();

    if (!$user) {
        return redirect()->back()->withErrors(['username' => 'User tidak ditemukan']);
    }

    // Update password baru
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->back()->with('status', 'Password berhasil direset');
}

}
