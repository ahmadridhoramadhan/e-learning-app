<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserClass;
use Illuminate\Http\Request;

// student
class UserClassController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $students = $user->userClass->users;

        return view('admin.user.listAll', ['students' => $students, 'class' => $user->userClass]);
    }

    public function createClass(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $userClass = new UserClass();
        $userClass->name = $request->name;
        $userClass->admin_id = auth()->user()->id;
        $userClass->save();

        return redirect()->route('admin.users');
    }

    public function editClass(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $userClass = auth()->user()->userClass;
        $userClass->name = $request->name;
        $userClass->save();

        return redirect()->route('admin.users');
    }

    public function createStudent(Request $request)
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
        $user->user_class_id = auth()->user()->userClass->id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = ($password);
        $user->is_admin = false;
        $user->save();

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
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('admin.users.detail', ['user' => $user]);
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

    public function createStudentWithFile(Request $request)
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
            $user->user_class_id = auth()->user()->userClass->id;
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = bcrypt($row['password']) ?? substr(md5(rand()), 0, 8);
            $user->is_admin = false;
            $user->save();
        }

        return redirect()->route('admin.users');
    }
}
