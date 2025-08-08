<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipHistory extends Model
{
    protected $fillable = [
        'member_id',
        'start_date',
        'expiration_date',
    ];

    public function member(){
        return $this->belongsTo(Member::class);
    }
}
