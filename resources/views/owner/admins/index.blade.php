@extends('layouts.owner')
@section('title', 'Kelola Admin')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Form Tambah Admin --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5 h-fit">
        <p class="text-[13px] font-semibold text-gray-900 mb-4">Tambah Admin Baru</p>
        <form action="{{ route('owner.admins.store') }}" method="POST" id="form-add-admin">
            @csrf
            <div class="space-y-3.5">
                <div>
                    <label class="block text-[12px] font-medium text-gray-500 mb-1">Nama Lengkap</label>
                    <input type="text" name="name"
                           class="w-full text-[13px] border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-gray-400 focus:ring-0 transition placeholder-gray-300"
                           placeholder="Contoh: Rina Wulandari" required>
                </div>
                <div>
                    <label class="block text-[12px] font-medium text-gray-500 mb-1">WhatsApp (untuk login)</label>
                    <input type="text" name="whatsapp"
                           class="w-full text-[13px] border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-gray-400 focus:ring-0 transition placeholder-gray-300"
                           placeholder="628xxxxxxxxx" required>
                </div>
                <div>
                    <label class="block text-[12px] font-medium text-gray-500 mb-1">Password</label>
                    <input type="password" name="password"
                           class="w-full text-[13px] border border-gray-200 rounded-lg px-3 py-2 outline-none focus:border-gray-400 focus:ring-0 transition placeholder-gray-300"
                           placeholder="••••••••" required>
                </div>
                <button type="submit" id="btn-add-admin"
                        class="w-full bg-gray-900 text-white text-[13px] font-medium py-2.5 rounded-lg
                               hover:bg-gray-800 active:scale-[.98] transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Simpan Akun Admin
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Admin --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 p-5">
        <p class="text-[13px] font-semibold text-gray-900 mb-4">Daftar Admin Aktif</p>

        @if(count($admins) === 0)
            <div class="py-12 text-center text-gray-300">
                <svg class="w-8 h-8 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 7a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <p class="text-[13px]">Belum ada admin terdaftar</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1">Nama</th>
                            <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1">WhatsApp</th>
                            <th class="pb-2.5 text-[11px] font-semibold text-gray-400 uppercase tracking-wide px-1 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($admins as $admin)
                        <tr class="group">
                            <td class="py-3 px-1 text-[13px] font-medium text-gray-800">{{ $admin->name }}</td>
                            <td class="py-3 px-1 text-[13px] text-gray-500 font-mono">{{ $admin->whatsapp }}</td>
                            <td class="py-3 px-1 text-right">
                                <button type="button"
                                        onclick="confirmDelete({{ $admin->id }}, '{{ $admin->name }}')"
                                        class="text-[12px] font-medium text-red-400 hover:text-red-600 transition">
                                    Hapus
                                </button>
                                <form id="delete-admin-{{ $admin->id }}"
                                      action="{{ route('owner.admins.store') }}/{{ $admin->id }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Confirm Delete Modal --}}
<div id="modal-delete" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/20">
    <div class="bg-white rounded-2xl p-6 w-80 shadow-lg">
        <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
            </svg>
        </div>
        <p class="text-[14px] font-semibold text-gray-900 text-center mb-1">Hapus Admin?</p>
        <p class="text-[12.5px] text-gray-400 text-center mb-5" id="modal-delete-name">Akun ini akan dihapus permanen.</p>
        <div class="flex gap-2">
            <button onclick="closeModal()" class="flex-1 py-2 rounded-lg border border-gray-200 text-[13px] font-medium text-gray-600 hover:bg-gray-50 transition">
                Batal
            </button>
            <button id="btn-confirm-delete"
                    class="flex-1 py-2 rounded-lg bg-red-500 text-white text-[13px] font-medium hover:bg-red-600 transition disabled:opacity-50">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    // Prevent double submit on add form
    const formAdmin = document.getElementById('form-add-admin');
    const btnAdmin  = document.getElementById('btn-add-admin');
    formAdmin.addEventListener('submit', function() {
        btnAdmin.disabled = true;
        btnAdmin.textContent = 'Menyimpan...';
    });

    // Delete modal
    let targetDeleteId = null;
    function confirmDelete(id, name) {
        targetDeleteId = id;
        document.getElementById('modal-delete-name').textContent = `Hapus akun "${name}"?`;
        document.getElementById('modal-delete').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('modal-delete').classList.add('hidden');
        targetDeleteId = null;
    }
    document.getElementById('btn-confirm-delete').addEventListener('click', function() {
        if (!targetDeleteId) return;
        this.disabled = true;
        this.textContent = 'Menghapus...';
        document.getElementById('delete-admin-' + targetDeleteId).submit();
    });
    // Close on backdrop
    document.getElementById('modal-delete').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection