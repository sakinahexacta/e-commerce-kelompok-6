<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{

    public function create()
    {
        return view('toko.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'address_id' => 'required|integer',
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        if ($user->store) {
            return redirect()->back()->with('error', 'Kamu sudah memiliki toko.');
        }

        $logoPath = $request->file('logo')->store('logos', 'public');

        Store::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'about' => $request->about,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'address_id' => $request->address_id,
            'logo' => $logoPath,
            'is_verified' => false,
        ]);

        $user->refresh();

        return redirect()->route('toko.orders.home')
            ->with('success', 'Toko berhasil didaftarkan! Tunggu verifikasi admin.');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $store = $user->store;

        return view('toko.dashboard', compact('store'));
    }

    public function orders()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            return redirect()->route('toko.register')
                ->with('error', 'Kamu belum memiliki toko.');
        }

        // Nanti kalau sudah ada model Order, ini bisa diganti ambil dari relasi
        $orders = []; // sementara kosong

        return view('toko.orders.home', compact('store', 'orders'));
    }

        // Detail pesanan
    public function orderDetail($id)
    {
        $user = Auth::user();
        $store = $user->store;

        // Pastikan toko sudah diverifikasi
        if (!$store || !$store->is_verified) {
            return redirect()->route('toko.dashboard')->with('error', 'Toko belum diverifikasi.');
        }

        $order = $store->orders()->findOrFail($id);

        return view('toko.orders.detail', compact('order'));
    }

    // Update status pesanan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed',
        ]);

        $user = Auth::user();
        $store = $user->store;

        $order = $store->orders()->findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('toko.orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    // Update nomor resi
    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'resi_number' => 'required|string|max:50',
        ]);

        $user = Auth::user();
        $store = $user->store;

        $order = $store->orders()->findOrFail($id);
        $order->update(['resi_number' => $request->resi_number]);

        return redirect()->route('toko.orders.show', $order->id)
            ->with('success', 'Nomor resi berhasil diperbarui.');
    }


}
