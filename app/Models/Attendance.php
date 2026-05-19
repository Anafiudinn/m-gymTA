<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable = ['user_id', 'admin_id', 'guest_name', 'guest_whatsapp', 'type'];

  public function user()
{
    return $this->belongsTo(User::class);
}

public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}

public function getTypeLabelAttribute()
{
    return match ($this->type) {
        'member_package' => 'Member Paket',
        'paid_visit' => 'Kunjungan Harian',
        default => ucfirst($this->type),
    };
}
}
