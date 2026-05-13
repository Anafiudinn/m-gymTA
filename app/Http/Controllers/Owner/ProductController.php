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

        $products = Product::when($search, function ($query) use ($search) {

                $query->where('nama_produk', 'like', '%' . $search . '%');

            })

            ->latest()

            ->paginate(15);

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $lowStockProducts = Product::where('stok', '<=', 5)->count();

        $totalStock = Product::sum('stok');

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
}