<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentHistory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function answerHistories()
    {
        return $this->hasMany(AnswerHistory::class);
    }

    public function scopeLeaderBoard($query, $room_id)
    {
        return $query->where('room_id', $room_id)->orderBy('score', 'desc')->limit(5)->get();
    }
}
