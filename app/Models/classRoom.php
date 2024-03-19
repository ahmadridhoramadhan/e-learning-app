<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classRoom extends Model
{
    use HasFactory;

    public function students()
    {
        return $this->hasMany(User::class);
    }

    public function scopeSearch($query, $val)
    {
        return $query->where('name', 'like', '%' . $val . '%');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
