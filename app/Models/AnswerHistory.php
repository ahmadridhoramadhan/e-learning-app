<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerHistory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function scopeGetWrongAnswer($query, $room_id, $assessmentHistory_id)
    {
        return $query->where('assessment_history_id', $assessmentHistory_id)
            ->where('room_id', $room_id)
            ->where('status', 'wrong')
            ->get();
    }

    public function scopeGetCorrectAnswer($query, $room_id, $assessmentHistory_id)
    {
        return $query->where('assessment_history_id', $assessmentHistory_id)
            ->where('room_id', $room_id)
            ->where('status', 'correct')
            ->get();
    }
}
