<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username_email' => 'required|string',
            'password' => 'required|string',
        ]);

        $login_type = filter_var($credentials['username_email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$login_type => $credentials['username_email'], 'password' => $credentials['password']], $request->filled('remember_me'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            Attendance::create([
                'user_id' => $user->id,
                'shift_start' => now(),
                'shift_end' => null,
            ]);
            
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.home');
            } else {
                return redirect()->route('pos.cashier');
            }
        }

        return back()->withErrors([
            'username_email' => 'These credentials do not match our records.',
        ])->onlyInput('username_email');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            \Log::info('User logging out: ' . $user->id);

            $attendance = Attendance::where('user_id', $user->id)
                ->whereNull('shift_end')
                ->latest('shift_start')
                ->first();

            if ($attendance) {
                \Log::info('Updating shift_end for attendance ID: ' . $attendance->id);
                $attendance->shift_end = now();
                $attendance->save();
                \Log::info('Shift end updated successfully for attendance ID: ' . $attendance->id);
            } else {
                \Log::warning('No attendance record found for user ID: ' . $user->id);
            }
        } else {
            \Log::warning('No authenticated user found during logout.');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
