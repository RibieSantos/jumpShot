<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    protected $fillable = [
        'name',
        'coach_id'
    ];

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }

    public function member()
    {
        return $this->belongsToMany(Member::class, 'team_players', 'team_id', 'member_id');
    }
    public function team()
{
    return $this->belongsToMany(Teams::class, 'team_players', 'member_id', 'team_id');
}

public function training()
{
    return $this->hasMany(Trainings::class, 'team_id');
}


}
