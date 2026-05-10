<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RetailController extends Controller
{
    /**
     * HALAMAN KASIR RETAIL
     * - Katalog produk
     * - History transaksi hari ini (optional tab)
     */
    public function index(Request $request)
    {
        $products = Product::where('stok', '>', 0)->get();

        $tab = $request->get('tab', 'katalog');

        $history = [];

        // TAB HISTORY (hanya transaksi retail hari ini)
        if ($tab === 'history') {
            $history = Transaction::with('items.product')
                ->where('category', 'retail')
                ->whereDate('created_at', today())
                ->latest()
                ->get();
        }

        return view('admin.retail.index', compact(
            'products',
            'history',
            'tab'
        ));
    }

    /**
     * PROSES TRANSAKSI RETAIL
     */
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;

            // =========================
            // VALIDASI & HITUNG TOTAL
            // =========================
            foreach ($request->products as $item) {

                $product = Product::lockForUpdate()->find($item['id']);

                if (!$product) {
                    throw new \Exception("Produk tidak ditemukan.");
                }

                if ($product->stok < $item['qty']) {
                    throw new \Exception("Stok {$product->nama_produk} tidak cukup!");
                }

                $grandTotal += $product->harga * $item['qty'];
            }

            // =========================
            // CREATE TRANSACTION HEADER
            // =========================
            $transaction = Transaction::create([
                'invoice_code'   => 'INV-' . now()->format('YmdHis'),
                'user_id'        => auth()->id(),
                'admin_id'       => auth()->id(),
                'category'       => 'retail',
                'amount'         => $grandTotal,
                'payment_method' => 'cash',
                'status'         => 'success',
                'source'         => 'onsite',
            ]);

            // =========================
            // SIMPAN ITEM + KURANGI STOK
            // =========================
            foreach ($request->products as $item) {

                $product = Product::lockForUpdate()->find($item['id']);

                $subtotal = $product->harga * $item['qty'];

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $product->id,
                    'qty'            => $item['qty'],
                    'price'          => $product->harga,
                    'subtotal'       => $subtotal,
                ]);

                $product->decrement('stok', $item['qty']);
            }

            DB::commit();

            return back()->with('success', 'Transaksi retail berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}