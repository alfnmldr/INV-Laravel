<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserLog;

class AuthController extends Controller
{

    public function showLoginForm(){
        return view('page.dashboard');
    }
   
public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Mencari user berdasarkan username
    $user = User::where('username', $request->username)->first();

    // Mengecek kecocokan password
    if ($user && Hash::check($request->password, $user->password)) {
        // Melakukan login
        Auth::login($user);

        // Regenerasi ID sesi setelah login untuk keamanan
        $request->session()->regenerate();

        // Menyimpan log login dengan alamat IP
        UserLog::create([
            'id_user'   => $user->id_user,
            'ip_address'=> $request->ip(),
            'login_time'=> now(),
        ]);

        // Redirect sesuai dengan role
        if ($user->role === 'admin') {
            return redirect()->route('index');
        } elseif ($user->role === 'manajer') {
            return redirect()->route('manajer.index');
        }
    }

    // Jika login gagal
    return back()->withErrors(['login_error' => 'Username atau Password salah.']);
}


    public function index()
    {
        return view('welcome');
    }
    
}
