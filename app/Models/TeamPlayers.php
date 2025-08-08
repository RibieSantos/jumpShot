<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPlayers extends Model
{
    protected $fillable = [
        'team_id',
        'member_id'
    ];
}
