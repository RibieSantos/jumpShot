<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $fillable = [
        'user_id',
        'profile_picture',
        'birthdate',
        'experience_level',
        'bio'
    ];
    protected static function booted()
    {
        static::deleting(function ($coach) {
            if ($coach->profile_picture && file_exists(public_path('coach/' . $coach->profile_picture))) {
                unlink(public_path('coach/' . $coach->profile_picture));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->hasMany(Teams::class);
    }
}
