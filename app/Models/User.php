<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function UserClass(): HasMany
    {
        return $this->hasMany(classRoom::class, 'admin_id');
    }
    public function classRooms(): HasMany
    {
        return $this->hasMany(classRoom::class, 'admin_id');
    }

    public function progress(): HasOne
    {
        return $this->hasOne(Progress::class);
    }

    public function assessmentHistories(): HasMany
    {
        return $this->hasMany(AssessmentHistory::class);
    }

    public function invited(): HasMany
    {
        return $this->hasMany(Invitation::class, 'to');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'from');
    }

    public function fromClassroom(): BelongsTo
    {
        return $this->belongsTo(classRoom::class, 'class_room_id');
    }

    public function warnings(): HasMany
    {
        return $this->hasMany(Warning::class, 'from');
    }

    public function scopeWarningExist($query, $room_id)
    {
        return ($this->warnings->where('room_id', $room_id)->first() !== null);
    }

    public function StudentWarnings()
    {
        return $this->hasMany(Warning::class, 'to');
    }

    public function scopeTotalStudentAllClass($query)
    {
        $classrooms = $this->classRooms;
        $total = 0;
        foreach ($classrooms as $classroom) {
            $total += $classroom->students->count();
        }
        return $total;
    }
}
