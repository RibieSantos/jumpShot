<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainings extends Model
{
    protected $fillable = [
        'team_id',
        'title',
        'training_date',
        'location',
        'focus'
    ];
    
    protected $casts = [
        'training_date' => 'datetime'
    ];
}
