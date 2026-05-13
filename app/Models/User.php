<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Membership;
use App\Models\PtMembership;
use App\Models\Transaction;
use App\Models\Attendance;
use App\Models\Setting;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * =========================================================
     * MASS ASSIGNABLE
     * =========================================================
     */
    protected $fillable = [
        'name',
        'whatsapp',
        'password',
        'role',
        'is_active_member',
        'member_code',
    ];

    /**
     * =========================================================
     * HIDDEN
     * =========================================================
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * =========================================================
     * CASTS
     * =========================================================
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active_member' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Semua membership member
     */
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Membership aktif terbaru
     */
    public function activeMembership()
    {
        return $this->hasOne(Membership::class)
            ->where('status', 'active')
            ->latestOfMany();
    }

    /**
     * Membership terakhir
     */
    public function latestMembership()
    {
        return $this->hasOne(Membership::class)
            ->latestOfMany();
    }

    /**
     * PT Membership
     */
    public function ptMemberships()
    {
        return $this->hasMany(PtMembership::class);
    }

    /**
     * Transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Attendances
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOM LOGIC
    |--------------------------------------------------------------------------
    */

    /**
     * Smart Visit Pricing
     *
     * PRIORITAS:
     * 1. Punya paket aktif => GRATIS
     * 2. Member aktivasi => harga member
     * 3. Guest => harga tamu
     */
    public function getVisitPrice()
    {
        /*
        |--------------------------------------------------------------------------
        | CEK PAKET AKTIF
        |--------------------------------------------------------------------------
        */

        $hasActivePackage = $this->memberships()
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->exists();

        // GRATIS
        if ($hasActivePackage) {

            return 0;
        }

        /*
        |--------------------------------------------------------------------------
        | MEMBER AKTIF
        |--------------------------------------------------------------------------
        */

        if ($this->is_active_member) {

            $price = Setting::where('key', 'visit_member')
                ->value('value');

            return (int) ($price ?? 7000);
        }

        /*
        |--------------------------------------------------------------------------
        | TAMU UMUM
        |--------------------------------------------------------------------------
        */

        $price = Setting::where('key', 'visit_tamu')
            ->value('value');

        return (int) ($price ?? 15000);
    }
}