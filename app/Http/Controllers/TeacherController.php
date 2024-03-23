<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboardPage(Request $request)
    {
        $user = Auth::user();
        $rooms = $user->rooms->take(6)->sortByDesc('created_at');

        // cek apkah userClass ada atau tidak
        if ($user->classRooms->isEmpty()) {
            return view('admin.dashboard', [
                'classrooms' => collect([]),
                'rooms' => $rooms,
                'class' => null,
            ]);
        }

        // hitung jumlah siswa yang terhubung dengan class yang di kelola admin
        $studentsCount = $user->totalStudentAllClass();

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
