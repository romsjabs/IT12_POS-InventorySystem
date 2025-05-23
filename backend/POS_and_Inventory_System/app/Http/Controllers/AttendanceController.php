<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function timeIn()
    {
        $user = Auth::user();
        Attendance::create([
            'user_id' => $user->id,
            'shift_start' => now(),
            'shift_end' => null,
        ]);
       
        return response()->json(['success' => true]);
    }

    public function timeOut()
    {
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)
            ->whereNull('shift_end')
            ->latest('shift_start')
            ->first();

        if ($attendance) {
            $attendance->shift_end = now();
            $attendance->save();
        }

        return response()->json(['success' => true]);
    }   
}
