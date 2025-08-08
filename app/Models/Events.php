<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = [
        'event_image',
        'title',
        'description',
        'event_date',
        'location'
    ];
    protected static function booted()
    {
        static::deleting(function ($event) {
            if ($event->profile_picture && file_exists(public_path('event/' . $event->profile_picture))) {
                unlink(public_path('event/' . $event->profile_picture));
            }
        });
    }
}
