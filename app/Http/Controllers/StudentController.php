<?php

namespace App\Http\Controllers;

use App\Models\classRoom;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboardPage()
    {
        $user = auth()->user();
        $assessmentHistories = $user->assessmentHistories ? $user->assessmentHistories->sortByDesc('created_at') : collect([]);
        $totalAlreadyDone = $assessmentHistories->count();
        // ambil rata rata score dengan maksimal 2 angka di belakang koma
        $averageScore = $assessmentHistories->avg('score') ? number_format($assessmentHistories->avg('score'), 2) : 0;

        return view('user.dashboard', [
            'student' => $user,
            'assessmentHistories' => $assessmentHistories,
            'totalAlreadyDone' => $totalAlreadyDone,
            'averageScore' => $averageScore,
        ]);
    }

    public function detail(User $user)
    {
        $assessmentHistories = $user->assessmentHistories;
        $averageScore = 0;

        if ($assessmentHistories->count() > 0) {
            $assessmentHistories = $assessmentHistories->sortByDesc('created_at');
            $averageScore = $assessmentHistories->avg('score');
        }
        return view('admin.user.detail', [
            'student' => $user,
            'assessmentHistories' => $assessmentHistories,
            'averageScore' => $averageScore
        ]);
    }

    public function listAllStudentsPage()
    {
        $user = auth()->user();
        return view('admin.user.listAll', ['classrooms' => $user->userClass]);
    }

    public function create(Request $request, classRoom $classroom)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:6'
        ]);

        // generate password if not provided
        $password = $request->password ?? substr(md5(rand()), 0, 8);

        // create user
        $user = new User();
        $user->class_room_id = $classroom->id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = ($password);
        $user->is_admin = false;
        $user->save();

        return redirect()->route('admin.users');
    }

    public function createWithFile(Request $request, classRoom $classroom)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $file = file($file->getRealPath());
        $data = array_map('str_getcsv', $file);
        $header = array_shift($data);

        foreach ($data as $row) {
            $row = array_combine($header, $row);
            $user = new User();
            $user->class_room_id = $classroom->id;
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = bcrypt($row['password']) ?? substr(md5(rand()), 0, 8);
            $user->is_admin = false;
            $user->save();
        }

        return redirect()->route('admin.users');
    }

    public function edit(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:6'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        $user->password = $request->password ?? substr(md5(rand()), 0, 8);

        $user->save();

        // return redirect()->route('admin.users.detail', ['user' => $user]);
        return redirect()->back();
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users');
    }

    public function resetData(User $user)
    {
        $user->assessmentHistories()->delete();
        return redirect()->route('admin.users');
    }

    public function historiesPage()
    {
        $user = auth()->user();
        $assessmentHistories = $user->assessmentHistories ? $user->assessmentHistories->sortByDesc('created_at') : collect([]);

        // grup assessment history berdasarkan hari yang sama
        $assessmentHistories = $assessmentHistories->groupBy(function ($item) {
            return $item->created_at->format('d M Y');
        });

        $dates = $assessmentHistories->keys();

        return view('user.histories', [
            'student' => $user,
            'assessmentHistoriesGroups' => $assessmentHistories,
            'dates' => $dates,
        ]);
    }

    public function ListTeachersAndRooms(Request $request, User $teacher)
    {
        $teachers = User::where('is_admin', 1)->get();
        return view('user.room.search', [
            'teachers' => $teacher->exists ? collect([$teacher]) : $teachers,
        ]);
    }
}
