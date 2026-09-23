@extends('layouts.admin')

@section('title', 'Pengaturan Pengiriman')
@section('header', 'Pengaturan Pengiriman')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

    {{-- Form Pengaturan --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Formula Perhitungan</h3>
                <p class="text-sm text-gray-500">Ongkir = Base Fare + (Jarak x Harga/km)</p>
            </div>
        </div>

        <form action="{{ route('admin.shipping.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Base Fare (Rp)</label>
                    <input type="number" name="base_fare" value="{{ old('base_fare', $settings->base_fare) }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                           min="0" step="100" required>
                    <p class="text-xs text-gray-400 mt-1">Biaya tetap yang dikenakan setiap pengiriman</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga per Km (Rp)</label>
                    <input type="number" name="price_per_km" value="{{ old('price_per_km', $settings->price_per_km) }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                           min="0" step="100" required>
                    <p class="text-xs text-gray-400 mt-1">Tarif per kilometer jarak tempuh</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Minimum Fare (Rp)</label>
                        <input type="number" name="minimum_fare" value="{{ old('minimum_fare', $settings->minimum_fare) }}"
                               class="w-full rounded-xl border border-gray-300 px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                               min="0" step="500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Maksimum Fare (Rp)</label>
                        <input type="number" name="maximum_fare" value="{{ old('maximum_fare', $settings->maximum_fare) }}"
                               class="w-full rounded-xl border border-gray-300 px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                               min="0" step="500" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pembulatan (Rp)</label>
                    <input type="number" name="rounding" value="{{ old('rounding', $settings->rounding) }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                           min="0" step="100" required>
                    <p class="text-xs text-gray-400 mt-1">Pembulatan ke atas per nominal ini (0 = tanpa pembulatan)</p>
                </div>
            </div>

            <button type="submit"
                    class="mt-6 w-full bg-orange-500 hover:bg-orange-600 active:bg-orange-700 transition-colors duration-200 text-white font-bold py-3 px-6 rounded-xl shadow-md hover:shadow-lg">
                Simpan Pengaturan
            </button>
        </form>
    </div>

    {{-- Preview & Info --}}
    <div class="space-y-6">

        {{-- Preview Kalkulasi --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Preview Perhitungan</h3>
                    <p class="text-sm text-gray-500">Coba hitung ongkir berdasarkan jarak</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jarak (km)</label>
                    <input type="number" id="previewDistance" value="5" min="0" step="0.1"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                </div>
                <button onclick="previewOngkir()" class="mt-5 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition">
                    Hitung
                </button>
            </div>

            <div id="previewResult" class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hidden">
                <p class="text-sm text-gray-500">Estimasi Ongkir</p>
                <p id="previewOngkir" class="text-2xl font-bold text-orange-500 mt-1"></p>
            </div>
        </div>

        {{-- Ringkasan Saat Ini --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Ringkasan Tarif</h3>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Base Fare</span>
                    <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($settings->base_fare, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Harga per Km</span>
                    <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($settings->price_per_km, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Minimum</span>
                    <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($settings->minimum_fare, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Maksimum</span>
                    <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($settings->maximum_fare, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-sm text-gray-500">Pembulatan</span>
                    <span class="text-sm font-semibold text-gray-800">Rp {{ number_format($settings->rounding, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Catatan --}}
        <div class="bg-yellow-50 p-5 rounded-2xl border border-yellow-200">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="text-sm font-bold text-yellow-800">Catatan Penting</h4>
                    <ul class="text-xs text-yellow-700 mt-2 space-y-1 list-disc list-inside">
                        <li>Jarak dihitung menggunakan OpenRouteService (jalan aktual, bukan garis lurus).</li>
                        <li>Koordinat diambil dari profil pelanggan dan UMKM.</li>
                        <li>Jika koordinat tidak tersedia, pengiriman tidak dapat dipilih (pesan error akan muncul).</li>
                        <li>Pesanan lama tidak akan terpengaruh oleh perubahan tarif ini.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
function previewOngkir() {
    const distance = document.getElementById('previewDistance').value;
    const resultDiv = document.getElementById('previewResult');
    const ongkirText = document.getElementById('previewOngkir');

    if (!distance || distance <= 0) {
        resultDiv.classList.add('hidden');
        return;
    }

    fetch('{{ route("admin.shipping.preview") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ distance: distance })
    })
    .then(res => res.json())
    .then(data => {
        ongkirText.textContent = data.formatted;
        resultDiv.classList.remove('hidden');
    })
    .catch(() => {
        resultDiv.classList.add('hidden');
    });
}
</script>

@endsection
