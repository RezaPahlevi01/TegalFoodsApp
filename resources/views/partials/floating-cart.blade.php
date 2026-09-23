@auth
<div id="floatingCart"
     class="fixed bottom-24 right-5 z-50 lg:bottom-8 lg:right-8"
     x-data="floatingCart()"
     x-init="init()">

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         @click.away="open = false"
         class="absolute bottom-16 right-0 w-80 max-h-[75vh] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden flex flex-col">

        <div class="bg-gradient-to-r from-orange-500 to-yellow-500 px-4 py-3 flex items-center justify-between">
            <h3 class="text-white font-bold text-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                </svg>
                Keranjang
                <span x-show="count > 0" x-text="'(' + count + ')'" class="text-xs font-normal opacity-80"></span>
            </h3>
            <button @click="open = false" class="text-white/80 hover:text-white text-lg leading-none">&times;</button>
        </div>

        <div class="flex-1 overflow-y-auto p-3 space-y-3" style="max-height: 55vh;">
            <template x-if="items.length === 0">
                <div class="text-center py-8 text-gray-400 text-sm">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    Keranjang kosong
                </div>
            </template>

            <template x-for="group in groups" :key="group.umkm_id">
                <div class="border border-gray-100 rounded-xl overflow-hidden">
                    <div class="bg-orange-50 px-3 py-2 flex items-center justify-between">
                        <span class="text-xs font-bold text-orange-700 truncate" x-text="group.umkm_nama"></span>
                        <span class="text-xs font-semibold text-orange-600" x-text="'Rp ' + formatNumber(group.total)"></span>
                    </div>
                    <div class="divide-y divide-gray-50">
                        <template x-for="item in group.items" :key="item.id">
                            <div class="flex items-center gap-2 px-3 py-2">
                                <img :src="item.gambar" :alt="item.nama"
                                     class="w-9 h-9 rounded-lg object-cover flex-shrink-0"
                                     onerror="this.style.display='none'">
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-gray-800 truncate" x-text="item.nama"></p>
                                    <div class="flex items-center gap-1 mt-0.5">
                                        <span class="text-[10px] text-gray-400" x-text="'x' + item.qty"></span>
                                        <span class="text-[10px] font-bold text-orange-600" x-text="'Rp ' + formatNumber(item.subtotal)"></span>
                                    </div>
                                </div>
                                <button @click="removeItem(item.id)"
                                        class="text-red-400 hover:text-red-600 p-0.5 rounded hover:bg-red-50 transition flex-shrink-0"
                                        title="Hapus">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    <div class="bg-gray-50 px-3 py-2">
                        <a :href="'/checkout?umkm_id=' + group.umkm_id"
                           class="block w-full bg-orange-500 hover:bg-orange-600 text-white text-center py-1.5 rounded-lg text-xs font-semibold transition">
                            Checkout
                        </a>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="items.length > 0" class="border-t bg-gray-50 p-3">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs text-gray-500">Total Semua</span>
                <span class="text-sm font-bold text-orange-600" x-text="'Rp ' + formatNumber(total)"></span>
            </div>
            <a href="{{ route('cart.index') }}"
               class="block w-full text-center text-gray-500 hover:text-orange-500 text-xs font-medium py-1 transition">
                Lihat Keranjang
            </a>
        </div>
    </div>

    <button @click="toggle()"
            class="relative w-14 h-14 bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 text-white rounded-full shadow-xl hover:shadow-2xl transition-all duration-200 flex items-center justify-center group">
        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
        </svg>
        <span x-show="count > 0"
              x-text="count"
              x-transition
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center shadow">
        </span>
    </button>

    <div x-show="justAdded"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="absolute bottom-16 right-0 bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-lg whitespace-nowrap">
        Ditambahkan ke keranjang!
    </div>
</div>

<script>
function floatingCart() {
    return {
        open: false,
        items: [],
        groups: [],
        count: 0,
        total: 0,
        justAdded: false,

        init() {
            this.fetchCart();
            window.addEventListener('cart-updated', () => this.fetchCart());
            window.addEventListener('cart-added', () => {
                this.fetchCart();
                this.justAdded = true;
                setTimeout(() => { this.justAdded = false; }, 2000);
            });
        },

        toggle() {
            this.open = !this.open;
            if (this.open) this.fetchCart();
        },

        async fetchCart() {
            try {
                const res = await fetch('{{ route("cart.api.data") }}', {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                this.items = data.items || [];
                this.groups = data.groups || [];
                this.count = data.count || 0;
                this.total = data.total || 0;
            } catch (e) {
                console.error('Gagal memuat keranjang:', e);
            }
        },

        async removeItem(cartId) {
            try {
                const res = await fetch('/cart/api/remove/' + cartId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    this.fetchCart();
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                }
            } catch (e) {
                console.error('Gagal menghapus item:', e);
            }
        },

        formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }
    };
}
</script>
@endauth
