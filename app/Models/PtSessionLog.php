<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtSessionLog extends Model
{
    protected $fillable = [
        'user_id','admin_id', 'pt_membership_id', 'member_name', 
        'coach_name', 'previous_session', 'current_session', 'note'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}
   public function membership()
    {
        return $this->belongsTo(PtMembership::class, 'pt_membership_id');
    }
}
