<div>
    {{-- Hanya tampil tombol/form apabila transaksi ada --}}
    @if ($transaksi)
        @if ($transaksi->status_pembayaran === 'Belum Bayar')
            @if (!$showForm)
                <button wire:click="openForm" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Bayar
                </button>
            @else
                <div class="space-y-4 p-4 border rounded bg-gray-50">
                    <div>
                        <x-label value="Total Tagihan" />
                        <div class="font-semibold">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </div>
                    </div>
                    <div>
                        <x-label for="jumlah_bayar" value="Jumlah Bayar" />
                        <x-input id="jumlah_bayar" type="number" min="0" step="0.01"
                            wire:model.live="jumlah_bayar" class="w-full mt-1" />
                        @error('jumlah_bayar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <x-label value="Kembalian" />
                        <div class="font-semibold">
                            Rp {{ number_format($kembalian, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button wire:click="savePayment"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                            Simpan Pembayaran
                        </button>
                        <button wire:click="cancel" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            Batal
                        </button>
                    </div>
                </div>
            @endif
        @else
            <div class="text-green-600 font-semibold">
                Sudah Lunas: Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}
                — Kembali Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
            </div>
        @endif
    @endif
</div>
