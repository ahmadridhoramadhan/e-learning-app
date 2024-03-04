<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    use HasFactory;

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studentProgress()
    {
        return $this->hasOne(Progress::class);
    }

    public function assessmentHistories()
    {
        return $this->hasMany(AssessmentHistory::class);
    }
}