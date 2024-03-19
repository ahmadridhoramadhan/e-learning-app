<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invitation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from');
    }
}
