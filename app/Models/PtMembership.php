<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtMembership extends Model
{
    protected $fillable = [
        'user_id', 'pt_package_id', 'total_sessions', 
        'remaining_sessions', 'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function package() {
        return $this->belongsTo(PtPackage::class, 'pt_package_id');
    }

    // Logic Potong Sesi
  public function subtractSession()
{
    if ($this->remaining_sessions > 0) {

        $this->decrement('remaining_sessions');

        $this->refresh();

        if ($this->remaining_sessions <= 0) {

            $this->update([
                'status' => 'completed'
            ]);
        }

        return true;
    }

    return false;
}
}