<?php

namespace App\Http\Controllers;

use App\Models\classRoom;
use App\Models\User;
use App\Models\UserClass;
use Illuminate\Http\Request;

// student
class UserClassController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('admin.user.listAll', ['classrooms' => $user->userClass]);
    }

    public function createClass(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $classroom = new classRoom();
        $classroom->name = $request->name;
        $classroom->admin_id = auth()->user()->id;
        $classroom->save();

        return redirect()->route('admin.users');
    }

    public function editClass(Request $request, classRoom $classroom)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $classroom->name = $request->name;
        $classroom->save();

        return redirect()->route('admin.users');
    }

    public function deleteClass(Request $request, classRoom $classroom)
    {
        $students = $classroom->students;
        foreach ($students as $student) {
            $student->delete();
        }
        $classroom->delete();
        return redirect()->route('admin.users');
    }

    public function createStudent(Request $request, classRoom $classroom)
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

    public function createStudentWithFile(Request $request, classRoom $classroom)
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

    public function editStudent(Request $request, User $user)
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

    public function deleteStudent(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users');
    }

    public function resetStudent(User $user)
    {
        $user->assessmentHistories()->delete();
        return redirect()->route('admin.users');
    }
}
