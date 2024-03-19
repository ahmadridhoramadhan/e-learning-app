<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Warning as WarningModel;
use Illuminate\Http\Request;

class WarningController extends Controller
{
    public function leaveRoom(Request $request, Room $room, User $user)
    {
        $warningModel = new WarningModel();
        $warningModel->updateOrCreate(
            [
                'from' => $user->id,
                'to' => $room->user->id,
                'room_id' => $room->id,
                'message' => 'keluar saat mengerjakan ' . $room->name,
            ],
        );
        return response()->json('success');
    }

    public function acceptWarning(Request $request, WarningModel $warning)
    {
        $warning->delete();
        return redirect()->back();
    }

    public function declineWarning(Request $request, WarningModel $warning)
    {
        $warning->status = 'declined';
        $warning->save();
        return redirect()->back();
    }

    public function pendingWarning(Request $request, WarningModel $warning)
    {
        $warning->status = 'pending';
        $warning->save();
        return redirect()->back();
    }
}
