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
    public function dashboardStudent()
    {
        $user = auth()->user();
        $assessmentHistories = $user->assessmentHistories ? $user->assessmentHistories->sortByDesc('created_at') : collect([]);
        $totalAlreadyDone = $assessmentHistories->count();
        // ambil rata rata score dengan maksimal 2 angka di belakang koma
        $averageScore = $assessmentHistories->avg('score') ? number_format($assessmentHistories->avg('score'), 2) : 0;

        return view('user.dashboard', [
            'student' => $user,
            'assessmentHistories' => $assessmentHistories,
            'totalAlreadyDone' => $totalAlreadyDone,
            'averageScore' => $averageScore,
        ]);
    }

    public function roomDetail(Room $room, AssessmentHistory $assessmentHistory)
    {

        // init
        $room->settings = json_decode($room->settings, true);
        $wrongAnswers = collect([]);
        $correctAnswers = collect([]);
        $averageScoreRoom = 0;

        if ($assessmentHistory->id) {
            // ambil history berdasarkan id yang di masukkan di route
            $wrongAnswers = AnswerHistory::where('assessment_history_id', $assessmentHistory->id)
                ->where('room_id', $room->id)
                ->where('status', 'wrong')
                ->get();

            $correctAnswers = AnswerHistory::where('assessment_history_id', $assessmentHistory->id)
                ->where('room_id', $room->id)
                ->where('status', 'correct')
                ->get();
        } else if ($room->assessmentHistories && $room->assessmentHistories->where('user_id', auth()->user()->id)->first()) {
            // cek apakah ada assessment history jika ada masukkan ke data dari assessment history terbaru
            $assessmentHistory = $room->assessmentHistories()->where('user_id', auth()->user()->id)->latest()->first();

            $wrongAnswers = AnswerHistory::where('assessment_history_id', $assessmentHistory->id)
                ->where('room_id', $room->id)
                ->where('status', 'wrong')
                ->get();

            $correctAnswers = AnswerHistory::where('assessment_history_id', $assessmentHistory->id)
                ->where('room_id', $room->id)
                ->where('status', 'correct')
                ->get();
        }

        // get average score student in this room
        if ($room->assessmentHistories) {
            $averageScoreRoom = $room->assessmentHistories->avg('score') ? number_format($room->assessmentHistories->avg('score'), 2) : 0;
        }

        // get leader board
        $leaderBoard = AssessmentHistory::where('room_id', $room->id)->orderBy('score', 'desc')->limit(5)->get();

        return view('user.room.detail', [
            'room' => $room,
            'settings' => $room->settings,
            'assessmentHistory' => $assessmentHistory ?? null,
            'wrongAnswers' => $wrongAnswers,
            'correctAnswers' => $correctAnswers,
            'leaderBoard' => $leaderBoard,
            'averageScoreRoom' => $averageScoreRoom,
        ]);
    }

    public function ListTeachersAndRooms()
    {
        $teachers = User::where('is_admin', 1)->get();
        return view('user.room.search', [
            'teachers' => $teachers,
        ]);
    }

    public function joinRoom(Request $request, Room $room)
    {
        $password = $request->password;

        if ($room->password && $room->password !== $password) {
            $validator = Validator::make([], []); // membuat instance validator kosong
            $validator->errors()->add('password', 'Password salah'); // menambahkan pesan error
            return redirect()->back()->withErrors($validator); // mengembalikan user dengan pesan error
        }

        // simpan password hash ke session
        $request->session()->put('room_password', bcrypt($password));

        return redirect()->route('user.room.join', $room->id);
    }

    public function joinRoomPage(Room $room)
    {
        // if room is not active
        if (!$room->is_active) {
            return redirect()->route('user.room.detail', $room->id)->with('error', 'Room is not active');
        }

        $settings = json_decode($room->settings);

        // cek apakah sudah ada progress
        if (auth()->user()->progress && auth()->user()->progress->where('room_id', $room->id)->first()) {
            $progress = (json_decode(auth()->user()->progress->progress));
            $questions = json_decode($progress->data);
            $maxTime = $progress->maxTime;
        } else {
            $maxTime = $settings->max_time;
            $questions = [];
            foreach ($room->questions as $question) {
                $questions[] = [
                    'id' => $question->id,
                    'question' => $question->question,
                    'flag' => false,
                    'selected' => null,
                    'answers' => $question->answers->shuffle(),
                ];
            }
            shuffle($questions);
        }

        return view('user.room.join', [
            'room' => $room,
            'questions' => json_encode($questions),
            'maxTime' => $maxTime,
        ]);
    }

    public function submitRoom(Request $request, Room $room)
    {
        // hapus session password
        $request->session()->forget('room_password');

        $user = auth()->user();
        if ($user->progress) {
            $user->progress->delete();
        }
        $correctAnswers = $room->questions;
        $studentsAnswers = json_decode($request->get('data'));
        $score = 0;
        $wrong = 0;

        $assessmentHistory = new AssessmentHistory;
        $answerHistory = new AnswerHistory;

        // urutkan studentsAnswers berdasarkan id
        usort($studentsAnswers, function ($a, $b) {
            return $a->question_id - $b->question_id;
        });

        // hitung salah, benar, dan score
        foreach ($studentsAnswers as $key => $answer) {
            if ($answer->answer_id == $correctAnswers[$key]->answer_id) {
                $score++;
            } else {
                $wrong++;
            }
        }

        $right = $score;

        // ubah score menjadi persentase
        $score = ($score / count($correctAnswers)) * 100;

        // create assessment history
        $assessmentHistoryId = $assessmentHistory->insertGetId([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'score' => $score,
            'right_answer' => $right,
            'wrong_answer' => $wrong,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        // masukkan data ke answer history
        foreach ($studentsAnswers as $key => $answer) {
            if ($answer->answer_id == $correctAnswers[$key]->answer_id) {
                $answerHistory->create([
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'question_id' => $correctAnswers[$key]->id,
                    'answer_id' => $answer->answer_id,
                    'assessment_history_id' => $assessmentHistoryId,
                    'status' => 'correct',
                ]);
            } else {
                $answerHistory->create([
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'question_id' => $correctAnswers[$key]->id,
                    'answer_id' => $answer->answer_id,
                    'assessment_history_id' => $assessmentHistoryId,
                    'status' => 'wrong',
                ]);
            }
        }

        return redirect()->route('user.room.detail', $room->id)->with('success', 'submit anda sudah di sinpan');
    }

    public function listAll(Request $request, Room $room)
    {
        return view('user.room.listAllUsersScore', [
            'assessmentHistories' => $room->assessmentHistories->sortByDesc('score'),
            'room' => $room,
        ]);
    }

    public function invitationsPage()
    {

        return view('user.notifications');
    }

    public function historiesPage()
    {
        $user = auth()->user();
        $assessmentHistories = $user->assessmentHistories ? $user->assessmentHistories->sortByDesc('created_at') : collect([]);
        $totalAlreadyDone = $assessmentHistories->count();
        // ambil rata rata score dengan maksimal 2 angka di belakang koma
        $averageScore = $assessmentHistories->avg('score') ? number_format($assessmentHistories->avg('score'), 2) : 0;

        return view('user.histories', [
            'student' => $user,
            'assessmentHistories' => $assessmentHistories,
            'totalAlreadyDone' => $totalAlreadyDone,
            'averageScore' => $averageScore,
        ]);
    }
}
