<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-400 leading-tight">
            {{ __('Detail Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-pink-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-2xl p-8 border border-pink-100">

                {{-- Pesan sukses --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Header --}}
                <h3 class="text-2xl font-bold text-pink-400 mb-6">Detail Pesanan #{{ $order->id }}</h3>

                {{-- Informasi Pembeli & Total --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-600">Nama Pembeli:</p>
                        <p class="font-semibold">{{ $order->buyer_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Total Pembayaran:</p>
                        <p class="font-semibold text-pink-500">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Status Pesanan:</p>
                        <p>
                            <span class="px-3 py-1 rounded-full text-sm
                                @if($order->status == 'pending') bg-yellow-200 text-yellow-800
                                @elseif($order->status == 'processing') bg-blue-200 text-blue-800
                                @elseif($order->status == 'shipped') bg-purple-200 text-purple-800
                                @elseif($order->status == 'completed') bg-green-200 text-green-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600">Nomor Resi:</p>
                        <p class="font-semibold">{{ $order->resi_number ?? '-' }}</p>
                    </div>
                </div>

                <hr class="my-6 border-pink-200">

                {{-- Update Status --}}
                <form action="{{ route('toko.orders.updateStatus', $order->id) }}" method="POST" class="mb-6">
                    @csrf
                    <label for="status" class="block text-gray-700 font-semibold mb-2">Ubah Status Pesanan</label>
                    <select name="status" id="status" class="border border-gray-300 rounded-lg p-3 w-full focus:ring-pink-300 focus:border-pink-300">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit" class="mt-3 bg-pink-300 hover:bg-pink-400 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                        Simpan Perubahan
                    </button>
                </form>

                {{-- Update Nomor Resi --}}
                <form action="{{ route('toko.orders.updateResi', $order->id) }}" method="POST">
                    @csrf
                    <label for="resi_number" class="block text-gray-700 font-semibold mb-2">Nomor Resi Pengiriman</label>
                    <input type="text" name="resi_number" id="resi_number" value="{{ $order->resi_number }}"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-pink-300 focus:border-pink-300" placeholder="Masukkan nomor resi">
                    <button type="submit" class="mt-3 bg-pink-300 hover:bg-pink-400 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                        Perbarui Resi
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
