@extends('layouts.owner')
@section('title', 'Pengaturan Harga')

@section('content')

<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <p class="text-[13px] font-semibold text-gray-900 mb-5">Master Harga Kunjungan & Aktivasi</p>

        <form action="{{ route('owner.settings.update') }}" method="POST" id="form-settings">
            @csrf
            <div class="space-y-4">

                {{-- Biaya Aktivasi --}}
                <div class="p-4 bg-gray-50 rounded-lg">
                    <label class="block text-[12px] font-medium text-gray-500 mb-1">Biaya Aktivasi (seumur hidup)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-[13px] text-gray-400 pointer-events-none">Rp</span>
                        <input type="number" name="biaya_aktivasi"
                               value="{{ $settings['biaya_aktivasi'] ?? 80000 }}"
                               class="w-full text-[13px] border border-gray-200 rounded-lg pl-9 pr-3 py-2 outline-none focus:border-gray-400 transition"
                               min="0">
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Dibayar sekali untuk mendapatkan harga member selamanya.</p>
                </div>

                {{-- Visit Prices --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-4 bg-emerald-50 rounded-lg">
                        <label class="block text-[12px] font-medium text-emerald-700 mb-1">Visit Member</label>
                        <p class="text-[11px] text-emerald-600 mb-2">Sudah aktivasi</p>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-[13px] text-emerald-500 pointer-events-none">Rp</span>
                            <input type="number" name="visit_member"
                                   value="{{ $settings['visit_member'] ?? 7000 }}"
                                   class="w-full text-[13px] bg-white border border-emerald-100 rounded-lg pl-9 pr-3 py-2 outline-none focus:border-emerald-300 transition"
                                   min="0">
                        </div>
                    </div>
                    <div class="p-4 bg-red-50 rounded-lg">
                        <label class="block text-[12px] font-medium text-red-600 mb-1">Visit Tamu</label>
                        <p class="text-[11px] text-red-400 mb-2">Belum aktivasi</p>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-[13px] text-red-400 pointer-events-none">Rp</span>
                            <input type="number" name="visit_tamu"
                                   value="{{ $settings['visit_tamu'] ?? 15000 }}"
                                   class="w-full text-[13px] bg-white border border-red-100 rounded-lg pl-9 pr-3 py-2 outline-none focus:border-red-300 transition"
                                   min="0">
                        </div>
                    </div>
                </div>
                
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <label class="block text-[12px] font-medium text-blue-700 mb-1">Bulanan Member</label>
                        <p class="text-[11px] text-blue-600 mb-2">Harga khusus untuk member aktif</p>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-[13px] text-blue-500 pointer-events-none">Rp</span>
                            <input type="number" name="bulanan_member"
                                   value="{{ $settings['bulanan_member'] ?? 150000 }}"
                                   class="w-full text-[13px] bg-white border border-blue-100 rounded-lg pl-9 pr-3 py-2 outline-none focus:border-blue-300 transition"
                                   min="0">

                </div>
                <div class="p-4 bg-blue-50 rounded-lg">
                        <label class="block text-[12px] font-medium text-blue-700 mb-1">Bulanan Non-Member</label>
                        <p class="text-[11px] text-blue-600 mb-2">Harga untuk member yang belum aktivasi</p>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-[13px] text-blue-500 pointer-events-none">Rp</span>
                            <input type="number" name="bulanan_non_member"
                                   value="{{ $settings['bulanan_non_member'] ?? 200000 }}"
                                   class="w-full text-[13px] bg-white border border-blue-100 rounded-lg pl-9 pr-3 py-2 outline-none focus:border-blue-300 transition"
                                   min="0">
                </div>
            </div>


                <div class="h-px bg-gray-100"></div>

                <button type="submit" id="btn-save-settings"
                        class="w-full bg-gray-900 text-white text-[13px] font-medium py-2.5 rounded-lg
                               hover:bg-gray-800 active:scale-[.98] transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Simpan Perubahan
                </button>

            </div>
        </form>
    </div>
</div>

{{-- Confirm before save modal --}}
<div id="modal-settings" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/20">
    <div class="bg-white rounded-2xl p-6 w-80 shadow-lg">
        <div class="w-10 h-10 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <p class="text-[14px] font-semibold text-gray-900 text-center mb-1">Simpan Perubahan Harga?</p>
        <p class="text-[12.5px] text-gray-400 text-center mb-5">Harga baru akan berlaku segera untuk semua transaksi berikutnya.</p>
        <div class="flex gap-2">
            <button onclick="closeSettingsModal()" class="flex-1 py-2 rounded-lg border border-gray-200 text-[13px] font-medium text-gray-600 hover:bg-gray-50 transition">
                Batal
            </button>
            <button id="btn-confirm-settings"
                    class="flex-1 py-2 rounded-lg bg-gray-900 text-white text-[13px] font-medium hover:bg-gray-800 transition disabled:opacity-50">
                Ya, Simpan
            </button>
        </div>
    </div>
</div>

<script>
    const formSettings = document.getElementById('form-settings');
    const btnSave      = document.getElementById('btn-save-settings');
    const modal        = document.getElementById('modal-settings');
    const btnConfirm   = document.getElementById('btn-confirm-settings');

    // Intercept submit → show confirm modal
    formSettings.addEventListener('submit', function(e) {
        e.preventDefault();
        modal.classList.remove('hidden');
    });

    function closeSettingsModal() {
        modal.classList.add('hidden');
    }

    // Confirmed → actually submit
    btnConfirm.addEventListener('click', function() {
        this.disabled = true;
        this.textContent = 'Menyimpan...';
        btnSave.disabled = true;
        formSettings.submit();
    });

    // Close on backdrop click
    modal.addEventListener('click', function(e) {
        if (e.target === this) closeSettingsModal();
    });
</script>
@endsection