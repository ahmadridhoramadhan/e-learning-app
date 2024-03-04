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
        if (!(Hash::check(Room::find($request->route('room'))->first()->password, $request->session()->get('room_password')))) {

            return redirect('user.room.detail', $request->route('room')->id)->with('error', 'Password salah');
        }

        return $next($request);
    }
}
