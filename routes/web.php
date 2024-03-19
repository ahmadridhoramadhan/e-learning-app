<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\authController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserClassController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarningController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::prefix('auth')->group(function () {
    Route::get('/redirect/google', [authController::class, 'googleRedirect'])->name('google.login');
    Route::get('/google/callback', [authController::class, 'googleCallback'])->name('google.callback');

    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});

// admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboardPage'])->name('admin.dashboard');

    // rooms
    Route::prefix('rooms')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('admin.rooms');
        Route::get('/create', [RoomController::class, 'createPage'])->name('admin.rooms.create');
        Route::post('/create', [RoomController::class, 'create'])->name('admin.rooms.create.process');
        Route::delete('/delete/{room}', [RoomController::class, 'delete'])->name('admin.rooms.delete.process');
        Route::delete('/reset/{room}', [RoomController::class, 'reset'])->name('admin.rooms.reset.process');
        Route::delete('/reset/questions/{room}', [RoomController::class, 'resetQuestions'])->name('admin.rooms.questions.reset.process');
        Route::put('/close/{room}', [RoomController::class, 'closeOrOpen'])->name('admin.rooms.closeOrOpen.process');
        Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('admin.rooms.edit');
        Route::get('/{room}', [RoomController::class, 'detailRoomPage'])->name('admin.rooms.detail');
        Route::get('/settings/{room}', [RoomController::class, 'settingsPage'])->name('admin.rooms.settings');
        Route::post('/settings/{room}', [RoomController::class, 'settings'])->name('admin.rooms.settings.process');
    });

    // users
    Route::prefix('users')->group(function () {
        Route::get('/', [UserClassController::class, 'index'])->name('admin.users');
        Route::get('/{user}', [UserClassController::class, 'detail'])->name('admin.users.detail');
        Route::post('/create/{classroom}', [UserClassController::class, 'createStudent'])->name('admin.users.create.process');
        Route::post('/create/file/{classroom}', [UserClassController::class, 'createStudentWithFile'])->name('admin.users.create.file.process');
        Route::post('/edit/{user}', [UserClassController::class, 'editStudent'])->name('admin.users.edit.process');
        Route::delete('/{user}', [UserClassController::class, 'deleteStudent'])->name('admin.users.delete.process');
        Route::put('/{user}', [UserClassController::class, 'resetStudent'])->name('admin.users.reset.process');
        Route::post('/class/create', [UserClassController::class, 'createClass'])->name('admin.class.create.process');
        Route::delete('/class/delete/{classroom}', [UserClassController::class, 'deleteClass'])->name('admin.class.delete.process');
        Route::post('/class/edit/{classroom}', [UserClassController::class, 'EditClass'])->name('admin.class.edit.process');
    });

    Route::put('warning/accept/{warning}', [WarningController::class, 'acceptWarning'])->name('admin.student.warning.accept');
    Route::put('warning/pending/{warning}', [WarningController::class, 'pendingWarning'])->name('admin.student.warning.pending');
    Route::put('warning/decline/{warning}', [WarningController::class, 'declineWarning'])->name('admin.student.warning.decline');

    Route::get('/invite/classroom/{room}/{classroom?}', 'App\Http\Controllers\InvitationController@inviteClassroomPage')->name('admin.invite.classroom');
    Route::post('/invite/classroom/{room}/{classroom?}/process', 'App\Http\Controllers\InvitationController@inviteClassroomProcess')->name('admin.invite.classroom.process');
    Route::delete('/invite/classroom/{room}/{classroom?}/delete/process', 'App\Http\Controllers\InvitationController@deleteInviteClassroomProcess')->name('admin.invite.classroom.delete.process');

    Route::get('profile/settings', [AdminController::class, 'settingsPage'])->name('admin.settings');
    Route::POST('profile/settings', [AdminController::class, 'settingsSave'])->name('admin.settings.save.process');
});

// user
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'dashboardStudent'])->name('user.dashboard');

    Route::prefix('rooms')->group(function () {
        Route::get('/detail/{room?}/{assessmentHistory?}', [UserController::class, 'roomDetail'])->name('user.room.detail');
        Route::post('/join/{room}', [UserController::class, 'joinRoom'])->name('user.room.join.process');
        Route::get('/join/{room}', [UserController::class, 'joinRoomPage'])->name('user.room.join')->middleware('room.auth');
        Route::post('/submit/{room}', [UserController::class, 'submitRoom'])->name('user.room.submit');
        Route::get('/leaderBoard/{room}', [UserController::class, 'listAllScore'])->name('user.room.leaderBoard');
    });

    Route::get('/invitations', [InvitationController::class, 'index'])->name('user.invitations');
    Route::get('/histories', [UserController::class, 'historiesPage'])->name('user.histories');
    Route::get('/search/{teacher?}', [UserController::class, 'ListTeachersAndRooms'])->name('user.room.search');
});

Route::get('/', function () {
    return view('home');
})->middleware('auth');


Route::get('/login', [authController::class, 'index'])->name('login');
Route::post('/login', [authController::class, 'manualLogin'])->name('login.process');
