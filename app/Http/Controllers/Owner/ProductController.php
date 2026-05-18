<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * =========================================================
     * LIST PRODUCT
     * =========================================================
     */
   public function index(Request $request)
{
    $search = $request->search;

    // Menampilkan semua produk (aktif & diarsipkan) agar Owner bisa meninjau seluruh inventori
    $products = Product::when($search, function ($query) use ($search) {
            $query->where('nama_produk', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(15);

    /*
    |--------------------------------------------------------------------------
    | SUMMARY / STATISTIK
    |--------------------------------------------------------------------------
    */
    // Total seluruh jenis produk terdaftar
    $totalProducts = Product::count();

    // Hanya menghitung produk AKTIF yang stoknya menipis
    $lowStockProducts = Product::where('is_active', true)->where('stok', '<=', 5)->count();

    // Hanya menjumlahkan total stok dari produk yang saat ini AKTIF dijual
    $totalStock = Product::where('is_active', true)->sum('stok');

    // 🌟 BARU: Menghitung total produk yang sedang diarsipkan (non-aktif)
    $archivedProducts = Product::where('is_active', false)->count();

    /*
    |--------------------------------------------------------------------------
    | BEST SELLER
    |--------------------------------------------------------------------------
    */
    $bestSellerProducts = TransactionItem::select(
            'product_id',
            DB::raw('SUM(qty) as total_qty')
        )
        ->with('product')
        ->groupBy('product_id')
        ->orderByDesc('total_qty')
        ->take(5)
        ->get();

    return view('owner.products.index', [
        'products' => $products,
        'search' => $search,
        'totalProducts' => $totalProducts,
        'lowStockProducts' => $lowStockProducts,
        'totalStock' => $totalStock,
        'archivedProducts' => $archivedProducts, // 🌟 Dioper ke view
        'bestSellerProducts' => $bestSellerProducts,
    ]);
}

    /**
     * =========================================================
     * DETAIL PRODUCT
     * =========================================================
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | SALES HISTORY
        |--------------------------------------------------------------------------
        */

        $salesHistory = TransactionItem::with([
                'transaction',
            ])
            ->where('product_id', $product->id)
            ->latest()
            ->paginate(20);

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalSold = TransactionItem::where('product_id', $product->id)
            ->sum('qty');

        $totalRevenue = TransactionItem::where('product_id', $product->id)
            ->sum('subtotal');

        return view('owner.products.show', [

            'product' => $product,

            'salesHistory' => $salesHistory,

            'totalSold' => $totalSold,
            'totalRevenue' => $totalRevenue,
        ]);
    }
    /**
     * 🌟 TOGGLE STATUS KEAKTIFAN PRODUK (SISI OWNER)
     */
    public function toggleProductStatus($id)
    {
        $product = Product::findOrFail($id);
        
        // Membalikkan status keaktifan
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'diaktifkan kembali' : 'dinonaktifkan (diarsipkan)';

        return redirect()->back()->with(
            'success', 
            'Produk ' . $product->nama_produk . ' berhasil ' . $status . '!'
        );
    }
}