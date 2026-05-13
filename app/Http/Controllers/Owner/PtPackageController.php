<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\PtPackage;
use Illuminate\Http\Request;

class PtPackageController extends Controller
{
    /**
     * =========================================================
     * LIST PAKET PT
     * =========================================================
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $packages = PtPackage::when($search, function ($query) use ($search) {

                $query->where('nama_paket', 'like', '%' . $search . '%')
                    ->orWhere('coach_name', 'like', '%' . $search . '%');

            })
            ->latest()
            ->paginate(10);

        $totalPackages = PtPackage::count();

        return view('owner.pt_packages.index', compact(
            'packages',
            'totalPackages',
            'search'
        ));
    }

    /**
     * =========================================================
     * STORE PAKET PT
     * =========================================================
     */
    public function store(Request $request)
    {
        $request->validate([

            'nama_paket' => 'required|string|max:255',

            'coach_name' => 'required|string|max:255',

            'coach_whatsapp' => 'required|string|max:20',

            'jumlah_sesi' => 'required|integer|min:1',

            'harga' => 'required|numeric|min:0',
        ]);

        PtPackage::create([

            'nama_paket' => $request->nama_paket,

            'coach_name' => $request->coach_name,

            'coach_whatsapp' => $request->coach_whatsapp,

            'jumlah_sesi' => $request->jumlah_sesi,

            'harga' => $request->harga,

            'is_active' => true,
        ]);

        return back()->with(
            'success',
            'Paket PT berhasil ditambahkan.'
        );
    }

    /**
     * =========================================================
     * UPDATE PAKET PT
     * =========================================================
     */
    public function update(Request $request, $id)
    {
        $package = PtPackage::findOrFail($id);

        $request->validate([

            'nama_paket' => 'required|string|max:255',

            'coach_name' => 'required|string|max:255',

            'coach_whatsapp' => 'required|string|max:20',

            'jumlah_sesi' => 'required|integer|min:1',

            'harga' => 'required|numeric|min:0',
        ]);

        $package->update([

            'nama_paket' => $request->nama_paket,

            'coach_name' => $request->coach_name,

            'coach_whatsapp' => $request->coach_whatsapp,

            'jumlah_sesi' => $request->jumlah_sesi,

            'harga' => $request->harga,
        ]);

        return back()->with(
            'success',
            'Paket PT berhasil diperbarui.'
        );
    }

    /**
     * =========================================================
     * AKTIF / NONAKTIF PAKET PT
     * =========================================================
     */
    public function toggleStatus($id)
    {
        $package = PtPackage::findOrFail($id);

        $package->update([
            'is_active' => !$package->is_active
        ]);

        return back()->with(
            'success',
            $package->is_active
                ? 'Paket PT berhasil diaktifkan.'
                : 'Paket PT berhasil dinonaktifkan.'
        );
    }

    /**
     * =========================================================
     * DELETE PAKET PT
     * =========================================================
     */
    public function destroy($id)
    {
        $package = PtPackage::findOrFail($id);

        // Cegah hapus jika masih dipakai
        if ($package->ptMemberships()->exists()) {

            return back()->with(
                'error',
                'Paket PT tidak bisa dihapus karena sudah digunakan member.'
            );
        }

        $package->delete();

        return back()->with(
            'success',
            'Paket PT berhasil dihapus.'
        );
    }
}