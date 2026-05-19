<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_code', 'user_id','guest_name','guest_whatsapp', 'admin_id', 'category', 'package_id',
        'amount', 'payment_method', 'status','source','sender_bank','sender_name','sender_account', 'rejection_reason', 'proof_attachment'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function items()
{
    return $this->hasMany(TransactionItem::class);
}
public function ptPackage()
{
    return $this->belongsTo(PtPackage::class, 'package_id');
}
public function transactionItems()
{
    return $this->hasMany(TransactionItem::class);
}
public function getCategoryLabelAttribute()
{
    return match ($this->category) {

        'activation' => 'Aktivasi Member',
        'monthly' => 'Paket Bulanan',
        'pt' => 'Personal Trainer',
        'visit' => 'Kunjungan',
        'retail' => 'Pembelian Produk',

        default => ucfirst($this->category),
    };
}

public function getStatusLabelAttribute()
{
    return match ($this->status) {

        'success' => 'Berhasil',
        'pending' => 'Menunggu',
        'rejected' => 'Ditolak',
        'cancelled' => 'Dibatalkan',

        default => ucfirst($this->status),
    };
}

}