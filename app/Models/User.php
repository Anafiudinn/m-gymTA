<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass Assignable.
     * Pastikan semua kolom baru di migration ada di sini.
     */
    protected $fillable = [
        'name',
        'whatsapp', // Ganti email ke whatsapp sesuai blueprint
        'password',
        'role',
        'is_active_member',
        'member_code',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting attributes.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active_member' => 'boolean', // Memastikan return true/false, bukan 1/0
        ];
    }

    

    // --- RELATIONS ---

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function ptMemberships()
    {
        return $this->hasMany(PtMembership::class);
    }

    // --- CUSTOM LOGIC (Smart Pricing) ---

    /**
     * Helper untuk Cek Harga Visit.
     * Logika: Paket Aktif (0) > Member Aktif (7k) > Tamu (15k)
     */
  public function getVisitPrice()
{
    // cek paket aktif
    $hasActivePackage = $this->memberships()
        ->where('status', 'active')
        ->whereDate('end_date', '>=', now())
        ->exists();

    // GRATIS jika punya paket aktif
    if ($hasActivePackage) {
        return 0;
    }

    // member aktivasi
    if ($this->is_active_member) {

        $price = Setting::where('key', 'visit_member')
            ->value('value');

        return (int) ($price ?? 7000);
    }

    // tamu umum
    $price = Setting::where('key', 'visit_tamu')
        ->value('value');

    return (int) ($price ?? 15000);
}

    public function latestMembership()
    {
        return $this->hasOne(Membership::class)->latestOfMany();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function activeMembership()
{
    return $this->hasOne(Membership::class)
        ->where('status', 'active')
        ->latestOfMany();
}
}
