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
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [TeacherController::class, 'dashboardPage'])->name('dashboard');

    // rooms
    Route::prefix('rooms')->name('rooms')->group(function () {
        Route::get('/', [RoomController::class, 'allMyRoomPage']);
        Route::get('/create', [RoomController::class, 'createPage'])->name('.create');
        Route::post('/create', [RoomController::class, 'create'])->name('.create.process');
        Route::delete('/delete/{room}', [RoomController::class, 'delete'])->name('.delete.process');
        Route::delete('/reset/{room}', [RoomController::class, 'reset'])->name('.reset.process');
        Route::delete('/reset/questions/{room}', [RoomController::class, 'resetQuestions'])->name('.questions.reset.process');
        Route::put('/close/{room}', [RoomController::class, 'closeOrOpenProcess'])->name('.closeOrOpen.process');
        Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('.edit');
        Route::get('/{room}', [RoomController::class, 'adminDetailPage'])->name('.detail');
        Route::get('/settings/{room}', [RoomController::class, 'settingsPage'])->name('.settings');
        Route::post('/settings/{room}', [RoomController::class, 'settings'])->name('.settings.process');
    });

    // users
    Route::prefix('users')->group(function () {
        Route::get('/', [StudentController::class, 'listAllStudentsPage'])->name('users');
        Route::get('/{user}', [StudentController::class, 'detail'])->name('users.detail');
        Route::post('/create/{classroom}', [StudentController::class, 'create'])->name('users.create.process');
        Route::post('/create/file/{classroom}', [StudentController::class, 'createWithFile'])->name('users.create.file.process');
        Route::post('/edit/{user}', [StudentController::class, 'edit'])->name('users.edit.process');
        Route::delete('/{user}', [StudentController::class, 'delete'])->name('users.delete.process');
        Route::put('/{user}', [StudentController::class, 'resetData'])->name('users.reset.process');

        Route::post('/class/create', [ClassroomController::class, 'create'])->name('class.create.process');
        Route::delete('/class/delete/{classroom}', [ClassroomController::class, 'delete'])->name('class.delete.process');
        Route::post('/class/edit/{classroom}', [ClassroomController::class, 'Edit'])->name('class.edit.process');
    });

    // warning
    Route::prefix('warning')->group(function () {
        Route::put('accept/{warning}', [WarningController::class, 'acceptWarning'])->name('student.warning.accept');
        Route::put('pending/{warning}', [WarningController::class, 'pendingWarning'])->name('student.warning.pending');
        Route::put('decline/{warning}', [WarningController::class, 'declineWarning'])->name('student.warning.decline');
    });

    // invitation
    Route::prefix('invite')->name('invite.')->group(function () {
        Route::get('/classroom/{room}/{classroom?}', [InvitationController::class, 'inviteClassroomPage'])->name('classroom');
        Route::post('/classroom/{room}/{classroom?}/process', [InvitationController::class, 'inviteClassroomProcess'])->name('classroom.process');
        Route::delete('/classroom/{room}/{classroom?}/delete/process', [InvitationController::class, 'deleteInviteClassroomProcess'])->name('classroom.delete.process');
    });
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
