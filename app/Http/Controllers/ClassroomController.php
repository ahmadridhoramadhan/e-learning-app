<?php

namespace App\Http\Controllers;

use App\Models\classRoom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function create(Request $request)
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

    public function delete(Request $request, classRoom $classroom)
    {
        $students = $classroom->students;
        foreach ($students as $student) {
            $student->delete();
        }
        $classroom->delete();
        return redirect()->route('admin.users');
    }

    public function edit(Request $request, classRoom $classroom)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $classroom->name = $request->name;
        $classroom->save();

        return redirect()->route('admin.users');
    }
}
