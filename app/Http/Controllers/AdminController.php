<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboardPage(Request $request)
    {
        $user = auth()->user();
        $rooms = $user->rooms->take(6);

        // cek apkah userClass ada atau tidak
        if (!$user->userClass) {
            return view('admin.dashboard', [
                'rooms' => $rooms,
                'class' => null,
            ]);
        }
        $students = auth()->user()->userClass->users()->take(5)->get();

        return view('admin.dashboard', [
            'rooms' => $rooms,
            'students' => $students,
            'class' => $user->userClass,
        ]);
    }
}
