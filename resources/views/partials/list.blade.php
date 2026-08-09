@if($mitra->count())
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ($mitra as $umkm)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden">
                <img src="{{ $media_url($umkm->logo_url) }}"
                     class="w-full h-48 object-cover">

                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">
                        {{ $umkm->nama_umkm }}
                    </h3>

                    <div class="mb-3 flex items-center gap-2">
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $umkm->isOpenNow() ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                            {{ $umkm->isOpenNow() ? 'Buka' : 'Tutup' }}
                        </span>

                        @if($umkm->jam_buka && $umkm->jam_tutup)
                            <span class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($umkm->jam_buka)->format('H:i') }} - {{ \Carbon\Carbon::parse($umkm->jam_tutup)->format('H:i') }}
                            </span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                        {{ $umkm->deskripsi }}
                    </p>

                    <a href="{{ route('umkm.show', $umkm->id) }}"
                       class="text-yellow-600 font-semibold hover:underline">
                        Lihat Detail ->
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="text-center text-gray-500 mt-10">
        UMKM tidak ditemukan.
    </p>
@endif
