<?php

namespace App\Http\Controllers;

use App\Models\classRoom;
use App\Models\invitation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = auth()->user()->invited;
        return view('user.invitations', compact('invitations'));
    }

    public function searchClassroom(Request $request)
    {
        $classrooms = classRoom::search($request->get('query'))->get();
        return response()->json($classrooms);
    }

    public function inviteClassroomPage(Request $request, Room $room, classRoom $classroom)
    {
        return view('admin.invite', ['classroom' => $classroom, 'room' => $room]);
    }

    public function inviteClassroomProcess(Request $request, Room $room, classRoom $classroom)
    {
        $message = 'tolong kerjakan segera!';
        if ($request->message) {
            $message = $request->message;
        }

        $students = $classroom->students;
        foreach ($students as $student) {
            $invitations = new invitation();
            $invitations->from = auth()->user()->id;
            $invitations->to = $student->id;
            $invitations->room_id = $room->id;
            $invitations->message = $message;
            $invitations->save();
        }
        return redirect()->route('admin.rooms.detail', $room->id);
    }

    public function deleteInviteClassroomProcess(Request $request, Room $room, classRoom $classroom)
    {
        $students = $classroom->students;

        foreach ($students as $student) {
            $student->invited()->where('room_id', $room->id)->delete();
        }
        return redirect()->route('admin.rooms.detail', $room->id);
    }
}
