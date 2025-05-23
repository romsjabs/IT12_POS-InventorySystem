<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'firstname'         => 'required|string|max:255',
            'middlename'        => 'nullable|string|max:255',
            'lastname'          => 'required|string|max:255',
            'extension'         => 'nullable|string|max:10',
            'gender'            => 'required|in:Male,Female',
            'birthdate'         => 'required|date',
            'username'          => 'required|string|max:255|unique:users,username',
            'email'             => 'required|email|max:255|unique:users,email',
            'password'          => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        // 1. Create the user (only auth info)
        $user = User::create([
            'username'      => $validated['username'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            // 'role' => 'user', // optional, defaults to 'user'
        ]);

        // 2. Create the user record (personal info)
        UserRecord::create([
            'user_id'    => $user->id,
            'firstname'  => $validated['firstname'],
            'middlename' => $validated['middlename'] ?? null,
            'lastname'   => $validated['lastname'],
            'extension'  => $validated['extension'] ?? null,
            'gender'     => $validated['gender'],
            'birthdate'  => $validated['birthdate'],
        ]);

        Auth::login($user);

        return redirect()->route('pos.cashier');
    }
}