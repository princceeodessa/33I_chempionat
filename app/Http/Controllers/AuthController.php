<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $passwordHash = Hash::make($request->password);

        DB::table('users')->insert([
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => $passwordHash,
            'role' => 0,
            'created_at' => now(),
        ]);

        return redirect()->route('loginForm')->with('message', 'Регистрация успешна!');
    }


    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return redirect()->back()->withErrors('Неверные данные для входа');
        }

        Auth::loginUsingId($user->id);
        session(['user_role' => $user->role]);

        return redirect()->route('calendar.index')->with('message', 'Добро пожаловать!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('loginForm');
    }
}
