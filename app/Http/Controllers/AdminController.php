<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboardPage(Request $request)
    {
        $user = auth()->user();
        $rooms = $user->rooms->take(6)->sortByDesc('created_at');

        // cek apkah userClass ada atau tidak
        if ($user->classRooms->isEmpty()) {
            return view('admin.dashboard', [
                'rooms' => $rooms,
                'class' => null,
            ]);
        }

        $classrooms = auth()->user()->classRooms;

        // hitung jumlah siswa yang terhubung dengan class yang di kelola admin
        $studentsCount = 0;
        foreach ($classrooms as $classroom) {
            $studentsCount += $classroom->students->count();
        }

        // hitung jumlah room yang ditutup
        $closedRoomsCount = $user->rooms->where('is_active', 0)->count();

        return view('admin.dashboard', [
            'rooms' => $rooms,
            'classrooms' => $user->classRooms,
            'studentsCount' => $studentsCount,
            'closedRoomsCount' => $closedRoomsCount,
        ]);
    }
}
