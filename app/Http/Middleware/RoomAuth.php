<?php

namespace App\Http\Middleware;

use App\Models\Room;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RoomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // check password
        $room = $request->route('room');
        if (!(Room::find($room)->first()->password == $request->session()->get('room_password'))) {
            return redirect()->route('user.room.detail', $room->id)->with('error', 'Password salah');
        }

        // check user warning exist
        if (auth()->user()->warningExist($room->id)) {
            return redirect()->route('user.room.detail', $room->id)->with('error', 'Anda tidak di izinkan masuk');
        }

        $user = auth()->user();
        if (!json_decode($room->settings)->answer_again) {
            if ($user->assessmentHistories->where('room_id', $room->id)->first()) {
                return redirect()->route('user.room.detail', $room->id)->with('error', 'Anda hanya bisa mengerjakan sekali');
            }
        }

        return $next($request);
    }
}
