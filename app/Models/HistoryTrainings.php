<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryTrainings extends Model
{
    protected $fillable = [
        'training_date',
        'location',
        'title',
        'focus'
    ];
}
