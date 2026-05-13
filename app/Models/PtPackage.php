<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtPackage extends Model
{
    protected $fillable = ['nama_paket','coach_name', 'coach_whatsapp', 'jumlah_sesi', 'harga', 'is_active'];

    public function ptMemberships() {
        return $this->hasMany(PtMembership::class);
    }
}