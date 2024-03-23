<?php

namespace App\Http\Controllers;

use App\Models\AnswerHistory;
use App\Models\AssessmentHistory;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function settingsPage(Request $request)
    {
        return view('admin.settings', ['user' => auth()->user()]);
    }

    public function settingsSave(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:8',
            'email' => 'required|string|email|max:255|min:8',
            'password' => 'nullable|string|min:8',
            'profile_picture_url' => 'nullable|string',
        ]);
        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password ?? $user->password;
        $user->profile_picture_url = $request->profile_picture_url;
        $user->save();

        return redirect()->back()->with('success', 'Settings updated');
    }

    // for an api
    public function searchTeacherAndRoom(Request $request)
    {
        switch ($request->categories) {
            case 'teacher':
                $teachers = User::where('is_admin', 1)->where('name', 'like', '%' . $request->name . '%')->get();
                return response()->json(
                    [
                        'status' => 'success',
                        'teachers' => $request->name == '' ? [] : $teachers,
                    ]
                );
                break;

            case 'room':
                $rooms = Room::where('name', 'like', '%' . $request->name . '%')->get();
                return response()->json([
                    'status' => 'success',
                    'rooms' => $request->name == '' ? [] : $rooms,
                ]);
                break;

            default:
                return response()->json([
                    'status' => 'error',
                    'message' => 'categories not found',
                ]);
                break;
        }
    }
}
