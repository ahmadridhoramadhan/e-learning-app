<?php

use App\Http\Controllers\AssessmentHistoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarningController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::prefix('auth')->group(function () {
    Route::get('/redirect/google', [AuthController::class, 'googleRedirect'])->name('google.login');
    Route::get('/google/callback', [AuthController::class, 'googleCallback'])->name('google.callback');

    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});

// admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [TeacherController::class, 'dashboardPage'])->name('admin.dashboard');

    // rooms
    Route::prefix('rooms')->group(function () {
        Route::get('/', [RoomController::class, 'allMyRoomPage'])->name('admin.rooms');
        Route::get('/create', [RoomController::class, 'createPage'])->name('admin.rooms.create');
        Route::post('/create', [RoomController::class, 'create'])->name('admin.rooms.create.process');
        Route::delete('/delete/{room}', [RoomController::class, 'delete'])->name('admin.rooms.delete.process');
        Route::delete('/reset/{room}', [RoomController::class, 'reset'])->name('admin.rooms.reset.process');
        Route::delete('/reset/questions/{room}', [RoomController::class, 'resetQuestions'])->name('admin.rooms.questions.reset.process');
        Route::put('/close/{room}', [RoomController::class, 'closeOrOpenProcess'])->name('admin.rooms.closeOrOpen.process');
        Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('admin.rooms.edit');
        Route::get('/{room}', [RoomController::class, 'adminDetailPage'])->name('admin.rooms.detail');
        Route::get('/settings/{room}', [RoomController::class, 'settingsPage'])->name('admin.rooms.settings');
        Route::post('/settings/{room}', [RoomController::class, 'settings'])->name('admin.rooms.settings.process');
    });

    // users
    Route::prefix('users')->group(function () {
        Route::get('/', [StudentController::class, 'listAllStudentsPage'])->name('admin.users');
        Route::get('/{user}', [StudentController::class, 'detail'])->name('admin.users.detail');
        Route::post('/create/{classroom}', [StudentController::class, 'create'])->name('admin.users.create.process');
        Route::post('/create/file/{classroom}', [StudentController::class, 'createWithFile'])->name('admin.users.create.file.process');
        Route::post('/edit/{user}', [StudentController::class, 'edit'])->name('admin.users.edit.process');
        Route::delete('/{user}', [StudentController::class, 'delete'])->name('admin.users.delete.process');
        Route::put('/{user}', [StudentController::class, 'resetData'])->name('admin.users.reset.process');

        Route::post('/class/create', [ClassroomController::class, 'create'])->name('admin.class.create.process');
        Route::delete('/class/delete/{classroom}', [ClassroomController::class, 'delete'])->name('admin.class.delete.process');
        Route::post('/class/edit/{classroom}', [ClassroomController::class, 'Edit'])->name('admin.class.edit.process');
    });

    Route::put('warning/accept/{warning}', [WarningController::class, 'acceptWarning'])->name('admin.student.warning.accept');
    Route::put('warning/pending/{warning}', [WarningController::class, 'pendingWarning'])->name('admin.student.warning.pending');
    Route::put('warning/decline/{warning}', [WarningController::class, 'declineWarning'])->name('admin.student.warning.decline');

    Route::get('/invite/classroom/{room}/{classroom?}', [InvitationController::class, 'inviteClassroomPage'])->name('admin.invite.classroom');
    Route::post('/invite/classroom/{room}/{classroom?}/process', [InvitationController::class, 'inviteClassroomProcess'])->name('admin.invite.classroom.process');
    Route::delete('/invite/classroom/{room}/{classroom?}/delete/process', [InvitationController::class, 'deleteInviteClassroomProcess'])->name('admin.invite.classroom.delete.process');
});

// user
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/', [StudentController::class, 'dashboardPage'])->name('user.dashboard');

    Route::prefix('rooms')->group(function () {
        Route::get('/detail/{room?}/{assessmentHistory?}', [RoomController::class, 'UserDetailPage'])->name('user.room.detail');
        Route::post('/join/{room}', [RoomController::class, 'join'])->name('user.room.join.process');
        Route::get('/join/{room}', [RoomController::class, 'joinedPage'])->name('user.room.join')->middleware('room.auth');
        Route::post('/submit/{room}', [RoomController::class, 'submit'])->name('user.room.submit');
        Route::get('/leaderBoard/{room}', [AssessmentHistoryController::class, 'listAllScore'])->name('user.room.leaderBoard');
    });

    Route::get('/invitations', [InvitationController::class, 'index'])->name('user.invitations');
    Route::get('/histories', [StudentController::class, 'historiesPage'])->name('user.histories');
    Route::get('/search/{teacher?}', [StudentController::class, 'ListTeachersAndRooms'])->name('user.room.search');
});


Route::get('profile/settings', [UserController::class, 'settingsPage'])->name('settings')->middleware('auth');
Route::POST('profile/settings', [UserController::class, 'settingsSave'])->name('settings.save.process')->middleware('auth');


Route::get('/', function () {
    return view('home');
})->middleware('auth');


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'manualLogin'])->name('login.process');
