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
        if ($user->classRooms->isEmpty()) {
            return view('admin.dashboard', [
                'rooms' => $rooms,
                'class' => null,
            ]);
        }

        // FIXME: buat agar menampilkan user yang terhubung dengan class dari admin dengan top 5 user paling sering mengerjakan room
        $classrooms = auth()->user()->classRooms;

        // hitung jumlah siswa yang terhubung dengan class yang di kelola admin
        $studentsCount = 0;
        foreach ($classrooms as $classroom) {
            $studentsCount += $classroom->students->count();
        }

        // hitung jumlah room
        $roomsCount = $user->rooms->count();

        // hitung jumlah room yang ditutup
        $closedRoomsCount = $user->rooms->where('is_closed', true)->count();

        return view('admin.dashboard', [
            'rooms' => $rooms,
            'classrooms' => $user->classRooms,
            'studentsCount' => $studentsCount,
            'roomsCount' => $roomsCount,
            'closedRoomsCount' => $closedRoomsCount,
        ]);
    }
}
// TODO: buat detail seperti room yang ditutup jumlah room
