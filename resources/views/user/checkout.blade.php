@extends('layouts.user')

@section('page-title', 'Checkout')

@section('content')

<form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <input type="hidden" name="umkm_id" value="{{ $umkm->id }}">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

        <!-- Header Section -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-5 flex items-center gap-4">
            <div class="bg-white/20 p-2.5 rounded-full text-white flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-white">
                    Checkout
                </h2>
                <p class="text-sm text-orange-100 mt-0.5">
                    {{ $umkm->nama_umkm }}
                </p>
            </div>
        </div>

        <div class="p-6 space-y-6">

            @if($shipping_error)
            <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium flex items-start gap-2">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <p class="font-semibold">Gagal menghitung ongkir</p>
                    <p class="mt-1">{{ $shipping_error }}</p>
                    <p class="mt-1">Silakan pilih metode <strong>Pick Up</strong> atau coba lagi nanti.</p>
                </div>
            </div>
            @endif

            <!-- Info Penerima & Kontak (Grid Layout) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- Nama Penerima -->
                <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">
                            Nama Penerima
                        </p>
                        <h3 class="font-bold text-gray-800 text-lg truncate">
                            {{ $profile->nama_lengkap }}
                        </h3>
                    </div>
                </div>

                <!-- Nomor Telepon -->
                <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">
                            Nomor Telepon
                        </p>
                        <h3 class="font-bold text-gray-800 text-lg truncate">
                            {{ $profile->nomor_telepon }}
                        </h3>
                    </div>
                </div>
                
            </div>

            <!-- Textarea Alamat -->
            <div class="space-y-2">
                <label class="font-bold text-gray-800 flex items-center gap-2">
                    Alamat Pengiriman
                </label>
                <textarea
                    name="alamat_pengiriman"
                    rows="4"
                    class="w-full rounded-xl border border-gray-300 p-4 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 resize-none shadow-sm"
                    placeholder="Masukkan alamat lengkap Anda..."
                    required>{{ old('alamat_pengiriman', $profile->alamat) }}</textarea>

                <div class="mt-4 border rounded-xl overflow-hidden">
                    <div class="bg-orange-50 px-4 py-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="text-sm font-bold text-orange-700">Item dari {{ $umkm->nama_umkm }}</span>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($carts as $cart)
                        <div class="flex items-center gap-3 px-4 py-3">
                            <img src="{{ $media_url($cart->makanan->gambar_url) }}"
                                 class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $cart->makanan->nama_makanan }}</p>
                                <p class="text-xs text-gray-500">x{{ $cart->qty }} &middot; Rp {{ number_format($cart->harga,0,',','.') }}</p>
                            </div>
                            <span class="text-sm font-bold text-orange-600 flex-shrink-0">Rp {{ number_format($cart->subtotal,0,',','.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <h3 class="font-bold text-xl mb-5 mt-6">
                    Metode Pengiriman
                </h3>

                <div class="space-y-3">

                    <label class="flex items-center gap-3 border rounded-xl p-4 cursor-pointer hover:border-orange-500 {{ $shipping_error ? 'opacity-50' : '' }}">

                        <input
                            type="radio"
                            name="metode_pengiriman"
                            value="delivery"
                            {{ $shipping_error ? '' : 'checked' }}
                            {{ $shipping_error ? 'disabled' : '' }}>

                        <div>
                            <p class="font-semibold">
                                🚚 Delivery
                                @if(!$shipping_error && $distance_km > 0)
                                <span class="text-sm font-normal text-gray-500">({{ $distance_km }} km, ~{{ round($duration_minutes) }} menit)</span>
                                @endif
                            </p>
                            <p class="text-sm text-gray-500">
                                Pesanan dikirim ke alamat tujuan
                            </p>
                        </div>

                    </label>

                    <label class="flex items-center gap-3 border rounded-xl p-4 cursor-pointer hover:border-orange-500">

                        <input
                            type="radio"
                            name="metode_pengiriman"
                            value="pickup"
                            {{ $shipping_error ? 'checked' : '' }}>

                        <div>
                            <p class="font-semibold">
                                🏪 Pick Up
                            </p>
                            <p class="text-sm text-gray-500">
                                Ambil sendiri di toko &middot; Ongkir Rp 0
                            </p>
                        </div>

                    </label>

                    <div class="mt-8 border rounded-2xl p-5 bg-gray-50">

                        <h3 class="font-bold text-lg mb-4">
                            Ringkasan Pembayaran
                        </h3>

                        <div class="flex justify-between mb-3">
                            <span>Subtotal</span>
                            <span>
                                Rp {{ number_format($total,0,',','.') }}
                            </span>
                        </div>

                        <div class="flex justify-between mb-3">
                            <span>Ongkir <span id="distanceInfo" class="text-xs text-gray-400 font-normal"></span></span>

                            <span id="ongkirText">
                                Rp {{ number_format($ongkir,0,',','.') }}
                            </span>
                        </div>

                        <hr class="my-3">

                        <div class="flex justify-between text-xl font-bold text-orange-500">

                            <span>Total</span>

                            <span id="totalText">
                                Rp {{ number_format($total + $ongkir,0,',','.') }}
                            </span>

                        </div>

                    </div>

                </div>
                <!-- Helper text sesuai gambar -->
                <p class="text-xs text-gray-500 flex items-start gap-1.5 mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Sertakan nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, dan kode pos agar pesanan mudah ditemukan.
                </p>
            </div>

        </div>

        <!-- Footer / Action Area -->
        <div class="p-6 bg-gray-50 border-t border-gray-100">

            <button
                type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 active:bg-orange-700 transition-colors duration-200 text-white font-bold py-3.5 px-6 rounded-xl shadow-md hover:shadow-lg flex justify-center items-center gap-2">

                Lanjut ke Pembayaran

            </button>

        </div>
    </div>
</form>

<script>

const subtotal = {{ $total }};
const baseOngkir = {{ $ongkir }};
const distanceKm = {{ $distance_km ?? 0 }};
const durationMinutes = {{ $duration_minutes ?? 0 }};
const hasShippingError = {{ $shipping_error ? 'true' : 'false' }};

const radios = document.querySelectorAll('input[name="metode_pengiriman"]');

const ongkirText = document.getElementById('ongkirText');
const totalText = document.getElementById('totalText');
const distanceInfo = document.getElementById('distanceInfo');

function formatRupiah(nominal)
{
    return 'Rp ' + nominal.toLocaleString('id-ID');
}

function updateTotal()
{
    const selected = document.querySelector('input[name="metode_pengiriman"]:checked');
    let ongkir = 0;

    if(selected && selected.value === 'delivery' && !hasShippingError)
    {
        ongkir = baseOngkir;
        distanceInfo.textContent = '(' + distanceKm + ' km)';
    }
    else
    {
        distanceInfo.textContent = '';
    }

    ongkirText.innerHTML = formatRupiah(ongkir);
    totalText.innerHTML = formatRupiah(subtotal + ongkir);
}

radios.forEach(radio => {

    radio.addEventListener('change', updateTotal);

});

updateTotal();

</script>
@endsection