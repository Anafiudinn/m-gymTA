<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable = ['user_id','guest_name', 'guest_whatsapp', 'type'];

  public function user()
{
    return $this->belongsTo(User::class);
}
}
