<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_code', 'user_id','guest_name','guest_whatsapp', 'admin_id', 'category', 
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

}