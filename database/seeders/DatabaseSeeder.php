<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'ahmadridhor0@gmail.com',
            'is_admin' => true,
            'password' => 'password',
        ]);

        \App\Models\classRoom::create([
            'name' => 'XII RPL 1',
            'admin_id' => 1,
        ]);

        \App\Models\User::create([
            'name' => 'siswa',
            'class_room_id' => 1,
            'email' => 'ahmadridhor02@gmail.com',
            'is_admin' => false,
            'password' => 'password',
        ]);

        \App\Models\Room::create([
            'user_id' => 1,
            'name' => 'Room 1',
            'password' => 'password',
            'settings' => json_encode([
                'max_time' => 60,
                'answer_again' => true,
                'show_result' => true,
                'leader_board' => true,
                'average_score' => true,
                'answer_history' => true,
                'list_score_user' => true,
                'focus' => true,
            ]),
        ]);

        \App\Models\Question::create([
            'room_id' => 1,
            'answer_id' => 1, // 'Jakarta
            'question' => 'What is the capital of Indonesia?',
        ]);

        \App\Models\Answer::create([
            'question_id' => 1,
            'answer' => 'Jakarta',
        ]);
        \App\Models\Answer::create([
            'question_id' => 1,
            'answer' => 'Bandung',
        ]);
        \App\Models\Answer::create([
            'question_id' => 1,
            'answer' => 'Surabaya',
        ]);
        \App\Models\Answer::create([
            'question_id' => 1,
            'answer' => 'Bali',
        ]);
    }
}
