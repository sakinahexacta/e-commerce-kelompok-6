<?php

namespace App\Http\Controllers;

use App\Models\Store;

class AdminStoreController extends Controller
{
    public function index()
    {
        // Ambil semua toko yang belum diverifikasi
        $pendingStores = Store::where('is_verified', 0)->get();
        $verifiedStores = Store::where('is_verified', 1)->get();

        return view('admin.verifikasi', compact('pendingStores', 'verifiedStores'));
    }

    public function approve($id)
    {
        Store::where('id', $id)->update([
            'is_verified' => 1
        ]);

        return back()->with('success', 'Toko berhasil disetujui.');
    }

    public function reject($id)
    {
        // Bisa juga tetap 0 atau bikin log tambahan kalau ditolak
        Store::where('id', $id)->update([
            'is_verified' => 0
        ]);

        return back()->with('success', 'Toko ditolak.');
    }
}
