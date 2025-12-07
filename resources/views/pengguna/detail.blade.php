<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <button onclick="history.back()">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                    viewBox="0 0 48 48" class="text-pink-300">
                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="4"
                        d="M31 36L19 24l12-12"/>
                </svg>
            </button>
            <h2 class="font-semibold text-xl text-pink-300 leading-tight">
                DETAIL PRODUK
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg py-10 px-10">
                <div class="flex flex-wrap gap-10">
                    <div class="flex gap-10">
                        <div class="w-[350px] h-[350px]">
                            <img src="{{ asset($product->thumbnail->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover rounded-lg">
                        </div>
                        <div>
                            <p class="text-left text-3xl font-semibold text-gray-700">
                                {{ $product->name }}
                            </p>
                            <p class="text-left text-xl font-normal text-gray-500">
                                Rp. {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <br>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" color-pink="600">
                                    <path fill="currentColor" d="m12 17.275l-4.15 2.5q-.275.175-.575.15t-.525-.2t-.35-.437t-.05-.588l1.1-4.725L3.775 10.8q-.25-.225-.312-.513t.037-.562t.3-.45t.55-.225l4.85-.425l1.875-4.45q.125-.3.388-.45t.537-.15t.537.15t.388.45l1.875 4.45l4.85.425q.35.05.55.225t.3.45t.038.563t-.313.512l-3.675 3.175l1.1 4.725q.075.325-.05.588t-.35.437t-.525.2t-.575-.15z"/>
                                </svg>
                                <p class="text- text-base font-normal text-pink-600"> 1,46 Juta Terjual </p>
                            </div>
                            <br>
                            <div>
                                <p class="text-left text-lg font-normal text-gray-700">
                                    Deskripsi Produk:
                                </p>
                                <p class="text-justify text-base font-normal text-gray-500 mt-2">
                                    {{ $product->description }}
                                </p>
                                <br>
                            </div>
                        </div>
                    </div>  
                </div>
                <br>
                <div class="w-full flex justify-end mt-10 gap-5">
                    <button class="bg-white hover:bg-pink-600 hover:text-white hover:border-pink-600 text-pink-200 border-2 border-pink-200 font-semibold py-2 px-4 w-[350px] h-[50px] rounded flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 512 512">
                            <circle cx="176" cy="416" r="32" fill="currentColor"/>
                            <circle cx="400" cy="416" r="32" fill="currentColor"/>
                            <path fill="currentColor" d="M456.8 120.78a23.92 23.92 0 0 0-18.56-8.78H133.89l-6.13-34.78A16 16 0 0 0 112 64H48a16 16 0 0 0 0 32h50.58l45.66 258.78A16 16 0 0 0 160 368h256a16 16 0 0 0 0-32H173.42l-5.64-32h241.66A24.07 24.07 0 0 0 433 284.71l28.8-144a24 24 0 0 0-5-19.93"/>
                        </svg>
                        Masukkan Keranjang
                    </button>                    
                    <button class="bg-pink-300 hover:bg-pink-600 text-white font-semibold py-2 px-4 w-[780px] h-[50px] rounded">
                        Beli Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
