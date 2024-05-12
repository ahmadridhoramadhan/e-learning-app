<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerHistory;
use App\Models\AssessmentHistory;
use App\Models\invitation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{

    public function UserDetailPage(Room $room, AssessmentHistory $assessmentHistory)
    {
        // init
        $room->settings = json_decode($room->settings, true);
        $wrongAnswers = collect([]);
        $correctAnswers = collect([]);
        $averageScore = 0;

        if ($assessmentHistory->id) {
            // ambil history berdasarkan id yang di masukkan di route
            $wrongAnswers = AnswerHistory::getWrongAnswer($room->id, $assessmentHistory->id);

            $correctAnswers = AnswerHistory::getCorrectAnswer($room->id, $assessmentHistory->id);
        } else if ($room->assessmentHistories && $room->assessmentHistories->where('user_id', auth()->user()->id)->first()) {
            // cek apakah ada assessment history jika ada masukkan ke data dari assessment history terbaru
            $assessmentHistory = $room->assessmentHistories()->where('user_id', auth()->user()->id)->latest()->first();

            $wrongAnswers = AnswerHistory::getWrongAnswer($room->id, $assessmentHistory->id);

            $correctAnswers = AnswerHistory::getCorrectAnswer($room->id, $assessmentHistory->id);
        }

        // get average score student in this room
        if ($room->assessmentHistories) {
            $averageScore = $room->getAverageScore();
        }

        // get leader board
        $leaderBoard = AssessmentHistory::leaderBoard($room->id);

        return view('user.room.detail', [
            'room' => $room,
            'settings' => $room->settings,
            'assessmentHistory' => $assessmentHistory ?? null,
            'wrongAnswers' => $wrongAnswers,
            'correctAnswers' => $correctAnswers,
            'leaderBoard' => $leaderBoard,
            'averageScore' => $averageScore,
        ]);
    }

    public function allMyRoomPage(Request $request)
    {
        $user = auth()->user();
        $rooms = $user->rooms()->get()->sortByDesc('created_at');

        return view('admin.room.index', [
            'rooms' => $rooms,
        ]);
    }

    public function adminDetailPage(Request $request, Room $room)
    {
        // init
        $assessmentHistories = collect([]);
        $averageScore = 0;
        $totalParticipant = 0;

        // get leader board
        if ($room->assessmentHistories) {
            $assessmentHistories = $room->assessmentHistories()->orderBy('score', 'desc')->get();
        }

        // average score student
        if ($room->assessmentHistories) {
            $averageScore = $room->getAverageScore();
        }

        // total participant by total assessment histories
        if ($room->assessmentHistories) {
            $totalParticipant = $room->assessmentHistories->count();
        }

        // ambil kelas apa saja yang di undang
        $invitations = invitation::where('room_id', $room->id)->where('status', 'pending')->get();
        $invitedClassrooms = collect([]);
        foreach ($invitations as $invitedClassroom) {
            $invitedClassrooms[] = $invitedClassroom->toUser->fromClassroom;
        }
        $invitedClassrooms = $invitedClassrooms->unique();

        return view('admin.room.detail', [
            'room' => $room,
            'assessmentHistories' => $assessmentHistories,
            'averageScore' => $averageScore,
            'totalParticipant' => $totalParticipant,
            'totalQuestion' => $room->questions->count(),
            'invitedClassrooms' => $invitedClassrooms,
            'studentsWhoReceiveWarnings' => $room->studentsWhoReceiveWarnings->where('status', 'pending')->load('fromUser'),
            'studentsWhoGetBanned' => $room->studentsWhoReceiveWarnings->where('status', 'declined')->load('fromUser')
        ]);
    }

    public function settingsPage(Request $request, Room $room)
    {
        return view('admin.room.settings', [
            'room' => $room,
        ]);
    }

    public function settings(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required',
            'password' => 'min:5|nullable',
            'timer' => 'numeric|nullable',
            'answer_again' => 'boolean|nullable',
            'show_result' => 'boolean|nullable',
            'leader_board' => 'boolean|nullable',
            'average_score' => 'boolean|nullable',
            'answer_history' => 'boolean|nullable',
            'list_score_user' => 'boolean|nullable',
            'focus' => 'boolean|nullable',
        ]);

        $settings = collect([
            'max_time' => $validated['timer'] ?? false,
            'answer_again' => isset($validated['answer_again']),
            'show_result' => isset($validated['show_result']),
            'leader_board' => isset($validated['leader_board']),
            'average_score' => isset($validated['average_score']),
            'answer_history' => isset($validated['answer_history']),
            'list_score_user' => isset($validated['list_score_user']),
            'focus' => isset($validated['focus']),
        ]);

        $room->settings = $settings->toJson();
        $room->name = $validated['name'];
        $room->password = $validated['password'] ?? null;
        $room->save();

        return redirect()->route('admin.rooms.edit', ['room' => $room->id]);
    }

    public function createPage(Request $request)
    {
        return view('admin.room.create.create');
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'password' => 'min:5|nullable',
            'timer' => 'numeric|nullable',
            'answer_again' => 'boolean|nullable',
            'show_result' => 'boolean|nullable',
            'leader_board' => 'boolean|nullable',
            'average_score' => 'boolean|nullable',
            'answer_history' => 'boolean|nullable',
            'list_score_user' => 'boolean|nullable',
            'focus' => 'boolean|nullable',
        ]);

        $user = auth()->user();
        $room = new Room();

        $settings = collect([
            'max_time' => $validated['timer'] ?? false,
            'answer_again' => isset($validated['answer_again']),
            'show_result' => isset($validated['show_result']),
            'leader_board' => isset($validated['leader_board']),
            'average_score' => isset($validated['average_score']),
            'answer_history' => isset($validated['answer_history']),
            'list_score_user' => isset($validated['list_score_user']),
            'focus' => isset($validated['focus']),
        ]);

        $dataNewRoom = [
            'user_id' => $user->id,
            'name' => $validated['name'],
            'password' => $validated['password'] ?? null,
            'settings' => $settings->toJson(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $roomId = $room->insertGetId($dataNewRoom);

        return redirect()->route('admin.rooms.edit', ['room' => $roomId]);
    }

    public function edit(Request $request, Room $room)
    {
        $room->load('questions.answers');

        foreach ($room->questions as $i => $question) {
            $answers = null;
            foreach ($question['answers'] as $answer) {
                $answers[] =  [
                    'id' => $answer->id,
                    'answer' => $answer->answer
                ];
            }
            $data = [
                'id' => $question['id'],
                'question' => $question['question'],
                'answers' => $answers,
            ];

            $room->questions[$i] = $data;
        }

        return view('admin.room.edit.edit', [
            'room' => $room,
        ]);
    }

    // for an API
    public function save(Request $request, Room $room)
    {
        $data = request()->get('data');

        // ubah string json menjadi array
        $data = json_decode($data, true);

        // jika data kosong maka kembalikan message data tidak boleh kosong
        if (empty($data)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak boleh kosong',
            ], 401);
        }

        $answerModel = new Answer();

        foreach ($data as $key => $question) {
            $questionId = $room->questions()->updateOrCreate(
                ['id' => $question['id'] ?? null],
                [
                    'room_id' => $room->id,
                    'question' => $question['question'],
                    'answer_id' => 0,
                ]
            );
            foreach ($question['answers'] as $key => $answer) {
                $answerModel->updateOrCreate(
                    ['id' => $answer['id'] ?? null],
                    [
                        'question_id' => $questionId->id,
                        'answer' => $answer['answer'],
                    ]
                );
            }

            // ambil id pertama dari answer
            $answerId = $answerModel->where('question_id', $questionId->id)->first()->id;
            // update answer_id pada question
            $room->questions()->where('id', $questionId->id)->update(['answer_id' => $answerId]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'save questions success',
        ]);
    }



    public function delete(Request $request, Room $room)
    {
        foreach ($room->questions as $i => $question) {
            $question->answers()->delete();
        }
        $room->questions()->delete();
        $room->delete();
        $this->reset($request, $room);
        return redirect()->route('admin.rooms');
    }

    public function reset(Request $request, Room $room)
    {
        foreach ($room->questions as $i => $question) {
            $question->answers()->delete();
        }
        $room->questions()->delete();
        foreach ($room->assessmentHistories as $assessmentHistory) {
            $assessmentHistory->delete();
        }
        $room->warnings()->delete();
        $room->invitations()->delete();
        return redirect()->route('admin.rooms.detail', ['room' => $room->id]);
    }

    public function resetQuestions(Request $request, Room $room)
    {
        foreach ($room->questions as $i => $question) {
            $question->answers()->delete();
        }
        $room->questions()->delete();
        return redirect()->route('admin.rooms.detail', ['room' => $room->id]);
    }

    public function closeOrOpenProcess(Request $request, Room $room)
    {
        $room->is_active = !$room->is_active;
        $room->save();
        return redirect()->route('admin.rooms.detail', ['room' => $room->id]);
    }

    public function joinedPage(Room $room)
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

        // dd($maxTime);

        return view('user.room.join', [
            'room' => $room,
            'questions' => json_encode($questions),
            'maxTime' => $maxTime,
        ]);
    }

    public function join(Request $request, Room $room)
    {
        $password = $request->password;

        if ($room->password != '' && $room->password !== $password) {
            $validator = Validator::make([], []); // membuat instance validator kosong
            $validator->errors()->add('password', 'Password salah'); // menambahkan pesan error
            return redirect()->back()->withErrors($validator); // mengembalikan user dengan pesan error
        }
        // simpan password hash ke session
        $request->session()->put('room_password', $password);

        return redirect()->route('user.room.join', $room->id);
    }

    public function submit(Request $request, Room $room)
    {
        // hapus session password
        $request->session()->forget('room_password');

        $user = auth()->user();
        if ($user->progress) {
            $user->progress->delete();
        }
        if ($user->warnings->where('room_id', $room->id)->where('status', 'pending')->first()) {
            $user->warnings->where('room_id', $room->id)->where('status', 'pending')->first()->delete();
        }
        if ($user->invited->first()) {
            $user->invited->first()->status = 'done';
            $user->invited->first()->save();
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
            // dd($answer->answer_id, $correctAnswers);
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

        return redirect()->route('user.room.detail', $room->id)->with('success', 'submit anda sudah di simpan');
    }
}
