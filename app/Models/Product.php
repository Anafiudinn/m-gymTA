<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['nama_produk', 'harga', 'stok', 'is_active'];

    // Helper untuk cek stok
    public function isAvailable($qty) {
        return $this->stok >= $qty;
    }
}