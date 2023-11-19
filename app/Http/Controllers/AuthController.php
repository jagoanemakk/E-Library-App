<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nama' => 'unique:users|required|min:3',
                'email' => 'unique:users|required|email',
                'password' => 'required|min:5',
            ],
            [
            'nama.unique' => 'Username sudah digunakan',
            'email.unique' => 'Email sudah digunakan',
        ],
        );

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['hak_akses'] = 'Member';

        // dd($validatedData);

        User::create($validatedData);

        return redirect('/login')->with('success', 'Akun berhasil didaftarkan!');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Login Gagal!');
    }

    public function logout()
    {
        Auth::logout();

        request()
            ->session()
            ->invalidate();

        request()
            ->session()
            ->regenerateToken();

        return redirect('/login');
    }
}
