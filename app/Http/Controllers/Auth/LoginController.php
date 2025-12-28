<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserLog;
class LoginController extends Controller
{

     public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Jika user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Login menggunakan ID user
            Auth::loginUsingId($user->id);

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('index'); // Ganti dengan rute admin yang sesuai
            } elseif ($user->role === 'manajer') {
                return redirect()->route('manajer.dashboard'); // Ganti dengan rute manajer yang sesuai
            }
        } else {
            // Jika kredensial salah
            return redirect()->back()->withErrors(['Invalid credentials']);
        }
    }

public function destroy(Request $request)
{
    $user = Auth::user();

    // Simpan log aktivitas logout
    UserLog::create([
    'user_id'    => $user->id,
    'ip_address' => $request->ip(),
    'login_time' => now(),
]);


    // Logout user
    Auth::logout();

    // Invalidate and regenerate session token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Atur header untuk menonaktifkan cache
    return redirect('/')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache');
}






}

