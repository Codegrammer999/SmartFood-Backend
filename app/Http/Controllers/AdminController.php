<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function register(Request $request)
    {
       $data = $request->validate([
        'name' => 'required|string|min:5|max:30',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|string|min:6|max:30|confirmed'
       ]);

       $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'role' => 'admin'
       ]);

       return redirect('/login');
    }

    public function login(Request $request)
    {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return redirect()->back()->with(['error' => 'Invalid credentials']);
        }
        return redirect()->intended('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/login');
    }
}
