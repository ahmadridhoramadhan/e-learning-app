<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $rooms = $user->rooms()->get();

        return view('admin.room.index', [
            'rooms' => $rooms,
        ]);
    }

    public function detailPage(Request $request, Room $room)
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
            $averageScore = $room->assessmentHistories->avg('score') ? number_format($room->assessmentHistories->avg('score'), 2) : 0;
        }

        // total participant by total assessment histories
        if ($room->assessmentHistories) {
            $totalParticipant = $room->assessmentHistories->count();
        }

        return view('admin.room.detail', [
            'room' => $room,
            'assessmentHistories' => $assessmentHistories,
            'averageScore' => $averageScore,
            'totalParticipant' => $totalParticipant,
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
        ]);

        $settings = collect([
            'max_time' => $validated['timer'] ?? false,
            'answer_again' => isset($validated['answer_again']),
            'show_result' => isset($validated['show_result']),
            'leader_board' => isset($validated['leader_board']),
            'average_score' => isset($validated['average_score']),
            'answer_history' => isset($validated['answer_history']),
            'list_score_user' => isset($validated['list_score_user']),
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
                $answers[] = $answer->answer;
            }
            $data = [
                'question' => $question['question'],
                'answers' => $answers,
            ];

            $room->questions[$i] = $data;
            // dd($data);
        }

        return view('admin.room.edit.edit', [
            'room' => $room,
        ]);
    }

    public function save(Request $request, Room $room)
    {
        $data = request()->get('data');

        // ubah string json menjadi array
        $data = json_decode($data, true);

        // jika data kosong maka kembalikan message data tidak boleh kosong
        if (empty($data)) {
            return response()->json([
                'message' => 'Data tidak boleh kosong',
            ]);
        }

        $answerModel = new Answer();

        // hapus semua pertanyaan dan jawaban yang ada
        $room->questions()->delete();

        foreach ($data as $key => $question) {
            $dataQuestion = [
                'room_id' => $room->id,
                'question' => $question['question'],
                'answer_id' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $questionId = $room->questions()->insertGetId($dataQuestion);
            foreach ($question['answers'] as $key => $answer) {
                $dataAnswer = [
                    'question_id' => $questionId,
                    'answer' => $answer,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $answerModel->insert($dataAnswer);
            }

            // ambil id pertama dari answer
            $answerId = $answerModel->where('question_id', $questionId)->first()->id;
            // update answer_id pada question
            $room->questions()->where('id', $questionId)->update(['answer_id' => $answerId]);
        }
        return response()->json([
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

    public function closeOrOpen(Request $request, Room $room)
    {
        $room->is_active = !$room->is_active;
        $room->save();
        return redirect()->route('admin.rooms.detail', ['room' => $room->id]);
    }
}
