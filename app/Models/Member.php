<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'profile_picture',
        'birthdate',
        'age',
        'address',
        'contact_number',
        'membership_start_date',
        'membership_expiration_date',

    ];
    protected static function booted()
    {
        static::deleting(function ($member) {
            if ($member->profile_picture && file_exists(public_path('member/' . $member->profile_picture))) {
                unlink(public_path('member/' . $member->profile_picture));
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membershipHistory()
    { 
        return $this->belongsTo(MembershipHistory::class);
    }


    public function team()
    {
        return $this->belongsToMany(Teams::class, 'team_players', 'member_id', 'team_id');
    }
    public function isExpiringSoon(): bool
    {
        if (!$this->membership_expiration_date) return false;

        $expiration = Carbon::parse($this->membership_expiration_date);
        return $expiration->isBetween(now(), now()->addDays(5));
    }
}
