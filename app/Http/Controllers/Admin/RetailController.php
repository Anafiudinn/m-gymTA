<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionItem;


class RetailController extends Controller
{
    public function index()
    {
        // Ambil produk yang stoknya masih ada
        $products = Product::where('stok', '>', 0)->get();
        return view('admin.retail.index', compact('products'));
    }

  public function store(Request $request)
{
    $request->validate([
        'products' => 'required|array|min:1',
        'products.*.id' => 'required|exists:products,id',
        'products.*.qty' => 'required|integer|min:1',
    ]);

    DB::transaction(function () use ($request) {

        $grandTotal = 0;

        /*
        HITUNG TOTAL
        */
        foreach ($request->products as $item) {

            $product = Product::findOrFail($item['id']);

            if ($product->stok < $item['qty']) {
                throw new \Exception("Stok {$product->nama_produk} tidak cukup!");
            }

            $grandTotal += $product->harga * $item['qty'];
        }

        /*
        BUAT HEADER TRANSACTION
        */
        $transaction = Transaction::create([

            'invoice_code' => 'INV-' . time(),

            'user_id' => auth()->id(),

            'admin_id' => auth()->id(),

            'category' => 'retail',

            'amount' => $grandTotal,

            'payment_method' => 'cash',

            'status' => 'success',
        ]);

        /*
        LOOP ITEM
        */
        foreach ($request->products as $item) {

            $product = Product::findOrFail($item['id']);

            $subtotal = $product->harga * $item['qty'];

            /*
            SIMPAN DETAIL ITEM
            */
            TransactionItem::create([

                'transaction_id' => $transaction->id,

                'product_id' => $product->id,

                'qty' => $item['qty'],

                'price' => $product->harga,

                'subtotal' => $subtotal,
            ]);

            /*
            KURANGI STOK
            */
            $product->decrement('stok', $item['qty']);
        }
    });

    return back()->with('success', 'Transaksi retail berhasil!');
}
}