<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return view('auth.login');
        }

        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    public function manualLogin(Request $request)
    {
        $validatedCredentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // login manual with where
        $user = new User();

        $user = $user->where('email', $validatedCredentials['email'])->where('password', $validatedCredentials['password'])->first();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sandi atau Email yang anda masukkan salah');
        }
        Auth::login($user);

        // if (!(Auth::attempt($validatedCredentials))) {
        //     return redirect()->route('login')->with('error', 'Sandi atau Email yang anda masukkan salah');
        // }

        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $user = Socialite::driver('google')->user();

        $userModel = User::where('email', $user->email)->first();


        if (!$userModel) {
            return redirect()->route('login');
        }

        // add profile picture if not exist
        if (!$userModel->profile_picture_url) {
            $userModel->profile_picture_url = $user->avatar;
            $userModel->save();
        }

        Auth::login($userModel);

        if ($userModel->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }
}
