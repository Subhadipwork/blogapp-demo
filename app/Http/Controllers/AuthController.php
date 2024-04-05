<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function login_action(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('home');
            }

            return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput($request->only('email'));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput($request->only('email'));

        }
    }


    public function register(Request $request)
    {
        return view('auth.register');
    }

    public function register_action(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
            ]);

            if ($validated->fails()) {
                return back()->withErrors($validated->errors())->withInput();
            }

            $credentials = $request->only('name', 'email', 'password');

            $registerUser = User::create($credentials);

            if ($registerUser) {
                return redirect()->route('login');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while registering.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        try {
            session()->invalidate();
            Auth::logout();
            return redirect()->route('home');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while logging out.']);
        }
    }
}
