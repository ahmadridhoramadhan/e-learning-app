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

    public function settingsPage(Request $request)
    {
        return view('admin.settings', ['user' => auth()->user()]);
    }

    public function settingsSave(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:8',
            'email' => 'required|string|email|max:255|min:8',
            'password' => 'nullable|string|min:8',
            'profile_picture_url' => 'nullable|string',
        ]);
        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ?? $user->password,
            'profile_picture_url' => $request->profile_picture_url,
        ]);

        dd($request->profile_picture_url);

        return redirect()->back()->with('success', 'Settings updated');
    }
}
