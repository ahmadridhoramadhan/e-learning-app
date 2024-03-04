<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function saveStudentProgress(Request $request, User $user, Room $room)
    {
        $data = $request->get('data');
        $maxTime = $request->get('maxTime');


        // gabung maxtime dan data menjadi array
        $data = json_encode(['maxTime' => $maxTime, 'data' => $data]);

        // update or create the progress
        $user->progress()->updateOrCreate(
            ['room_id' => $room->id],
            ['progress' => $data]
        );

        // cara mencari tau tipe data dari $maxtime


        // standard response success
        return response()->json([
            'status' => 'success',
            'message' => 'Progress saved',
        ]);
    }
}
