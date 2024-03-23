<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class AssessmentHistoryController extends Controller
{
    public function listAllScore(Request $request, Room $room)
    {
        return view('user.room.listAllUsersScore', [
            'assessmentHistories' => $room->assessmentHistories->sortByDesc('score'),
            'room' => $room,
        ]);
    }
}
