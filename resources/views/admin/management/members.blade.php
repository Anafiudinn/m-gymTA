@extends('layouts.admin')

@section('content')
<div class="p-6">
    {{-- Header & Search --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">
        <div>
            <h2 class="text-3xl font-black text-slate-800">DATA MEMBER</h2>
            <p class="text-sm text-slate-500">Kelola member, paket, dan aktivitas gym.</p>
        </div>
        {{-- Search Form --}}
        <form method="GET" action="{{ route('admin.data.members') }}">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode / whatsapp..." class="w-full lg:w-80 bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 focus:outline-none">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
            </div>
        </form>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-2xl text-sm font-bold">{{ session('success') }}</div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm">
            <p class="text-xs font-black uppercase text-slate-400 mb-2">Total Member</p>
            <h3 class="text-4xl font-black text-slate-800">{{ $totalMembers }}</h3>
        </div>
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm">
            <p class="text-xs font-black uppercase text-slate-400 mb-2">Sudah Aktivasi</p>
            <h3 class="text-4xl font-black text-green-500">{{ $activeMembers }}</h3>
        </div>
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm">
            <p class="text-xs font-black uppercase text-slate-400 mb-2">Paket Expired</p>
            <h3 class="text-4xl font-black text-red-500">{{ $expiredPackages }}</h3>
        </div>
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm">
            <p class="text-xs font-black uppercase text-slate-400 mb-2">PT Aktif</p>
            <h3 class="text-4xl font-black text-orange-500">{{ $ptActive }}</h3>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-5 text-left text-[11px] uppercase font-black text-slate-400">Member</th>
                        <th class="px-6 py-5 text-left text-[11px] uppercase font-black text-slate-400">Status Member</th>
                        <th class="px-6 py-5 text-left text-[11px] uppercase font-black text-slate-400">Paket</th>
                        <th class="px-6 py-5 text-left text-[11px] uppercase font-black text-slate-400">Berakhir</th>
                        <th class="px-6 py-5 text-center text-[11px] uppercase font-black text-slate-400">PT</th>
                        <th class="px-6 py-5 text-right text-[11px] uppercase font-black text-slate-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($members as $m)
                    @php $membership = $m->latestMembership; $hasPackage = $membership ? true : false; $packageExpired = $membership ? \Carbon\Carbon::parse($membership->end_date)->isPast() : false; $hasPT = $m->ptMemberships->where('status', 'active')->count(); @endphp
                    <tr class="hover:bg-slate-50/60 transition">
                        {{-- Member --}}
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-red-500 text-white flex items-center justify-center font-black shadow-lg">{{ strtoupper(substr($m->name, 0, 1)) }}</div>
                                <div>
                                    <h4 class="font-black text-slate-800">{{ $m->name }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-orange-500 text-xs font-black">{{ $m->member_code ?? 'NON MEMBER' }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span class="text-sm text-slate-500">{{ $m->whatsapp }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        {{-- Status Member --}}
                        <td class="px-6 py-5">
                            @if($m->is_active_member)
                            <span class="bg-green-100 text-green-600 text-xs font-black px-4 py-2 rounded-xl">MEMBER</span>
                            @else
                            <span class="bg-red-100 text-red-500 text-xs font-black px-4 py-2 rounded-xl">NON MEMBER</span>
                            @endif
                        </td>
                        {{-- Package Status --}}
                        <td class="px-6 py-5">
                            @if(!$hasPackage)
                            <div><p class="text-sm font-bold text-slate-400 italic">Belum ada paket</p></div>
                            @elseif($packageExpired)
                            <div><p class="font-black text-red-500">Paket Habis</p><p class="text-xs text-slate-400">Silakan perpanjang paket</p></div>
                            @else
                            <div><p class="font-black text-slate-800">Membership Gym</p><p class="text-xs text-slate-400">Aktif digunakan</p></div>
                            @endif
                        </td>
                        {{-- End Date --}}
                        <td class="px-6 py-5">
                            @if($membership)
                            <div>
                                <p class="font-black text-slate-700">{{ \Carbon\Carbon::parse($membership->end_date)->format('d M Y') }}</p>
                                <p class="text-xs text-slate-400">{{ $packageExpired ? 'Sudah habis' : 'Masih aktif' }}</p>
                            </div>
                            @else
                            <span class="text-slate-300 italic text-sm">-</span>
                            @endif
                        </td>
                        {{-- PT --}}
                        <td class="px-6 py-5 text-center">
                            @if($hasPT)
                            <span class="bg-orange-100 text-orange-500 text-xs font-black px-4 py-2 rounded-xl">{{ $hasPT }} AKTIF</span>
                            @else
                            <span class="text-slate-300 text-sm">-</span>
                            @endif
                        </td>
                        {{-- Actions --}}
                        <td class="px-6 py-5">
                            <div class="flex justify-end items-center gap-2">
                                {{-- Detail --}}
                                <button onclick='openDetailModal({id: "{{ $m->id }}", name: "{{ $m->name }}", whatsapp: "{{ $m->whatsapp }}", member_code: "{{ $m->member_code ?? "NON MEMBER" }}", package: "{{ !$hasPackage ? "Belum Ada Paket" : ($packageExpired ? "Membership Habis" : "Membership Aktif") }}", expired: "{{ $membership ? \Carbon\Carbon::parse($membership->end_date)->format("d M Y") : "-" }}", package_status: "{{ !$hasPackage ? "Belum Ada Paket" : ($packageExpired ? "Expired" : "Aktif") }}", is_member: {{ $m->is_active_member ? 'true' : 'false' }}, visit: "{{ $m->attendances_count ?? 0 }}", streak: "{{ rand(1,30) }}", pt: "{{ $hasPT ? 'Aktif' : 'Tidak Ada' }}"})' class="w-11 h-11 rounded-2xl bg-orange-50 hover:bg-orange-500 hover:text-white text-orange-500 transition"><i class="fas fa-id-card"></i></button>
                                {{-- Edit --}}
                                <button onclick="openEditModal('{{ $m->id }}', '{{ $m->name }}', '{{ $m->whatsapp }}')" class="w-11 h-11 rounded-2xl bg-blue-50 hover:bg-blue-500 hover:text-white text-blue-500 transition"><i class="fas fa-edit"></i></button>
                                {{-- Toggle --}}
                                <form action="{{ route('admin.data.members.toggle', $m->id) }}" method="POST">@csrf @method('PATCH')<button type="submit" class="w-11 h-11 rounded-2xl bg-slate-100 hover:bg-slate-800 hover:text-white text-slate-500 transition"><i class="fas fa-power-off"></i></button></form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-20 text-slate-400">Tidak ada data member.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- Pagination --}}
    <div class="mt-6">{{ $members->links() }}</div>

    {{-- Detail Modal --}}
    <div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-2xl rounded-[2.5rem] overflow-hidden shadow-2xl relative">
            {{-- Close --}}
            <button onclick="closeDetailModal()" class="absolute top-5 right-5 w-10 h-10 rounded-xl hover:bg-white/20 text-white z-10"><i class="fas fa-times"></i></button>
            {{-- Header Card --}}
            <div class="bg-gradient-to-br from-orange-500 via-red-500 to-orange-600 p-8 text-white">
                           <div class="flex items-start justify-between">
                <div class="flex items-center gap-5">
                    <div class="w-24 h-24 rounded-[2rem] bg-white/20 border border-white/30 flex items-center justify-center text-4xl font-black"><span id="detail_avatar">A</span></div>
                    <div>
                        <p class="uppercase text-xs font-black tracking-[0.3em] text-white/70 mb-2">Member Gym</p>
                        <h2 id="detail_name" class="text-4xl font-black leading-none mb-2">-</h2>
                        <div class="flex items-center gap-2">
                            <span id="detail_code" class="bg-white/20 px-4 py-1 rounded-full text-xs font-black">-</span>
                            <span id="detail_member_status" class="bg-green-400 text-green-950 px-4 py-1 rounded-full text-xs font-black">MEMBER</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Content --}}
        <div class="p-8">
            {{-- Grid Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                <div class="bg-slate-50 rounded-3xl p-5">
                    <p class="text-xs uppercase font-black text-slate-400 mb-2">WhatsApp</p>
                    <h4 id="detail_whatsapp" class="font-black text-slate-800 text-lg">-</h4>
                </div>
                <div class="bg-slate-50 rounded-3xl p-5">
                    <p class="text-xs uppercase font-black text-slate-400 mb-2">Paket</p>
                    <h4 id="detail_package" class="font-black text-slate-800 text-lg">-</h4>
                </div>
                <div class="bg-slate-50 rounded-3xl p-5">
                    <p class="text-xs uppercase font-black text-slate-400 mb-2">Masa Aktif</p>
                    <h4 id="detail_expired" class="font-black text-slate-800 text-lg">-</h4>
                </div>
                <div class="bg-slate-50 rounded-3xl p-5">
                    <p class="text-xs uppercase font-black text-slate-400 mb-2">Status Paket</p>
                    <h4 id="detail_package_status" class="font-black text-lg">-</h4>
                </div>
            </div>
            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-orange-50 rounded-3xl p-5 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-500 flex items-center justify-center mx-auto mb-3"><i class="fas fa-dumbbell"></i></div>
                    <h3 id="detail_visit" class="text-2xl font-black text-slate-800">0</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase">Kehadiran</p>
                </div>
                <div class="bg-blue-50 rounded-3xl p-5 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-500 flex items-center justify-center mx-auto mb-3"><i class="fas fa-fire"></i></div>
                    <h3 id="detail_streak" class="text-2xl font-black text-slate-800">0</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase">Streak</p>
                </div>
                <div class="bg-green-50 rounded-3xl p-5 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-500 flex items-center justify-center mx-auto mb-3"><i class="fas fa-user-ninja"></i></div>
                    <h3 id="detail_pt" class="text-2xl font-black text-slate-800">0</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase">PT Aktif</p>
                </div>
            </div>
            {{-- Action --}}
            <div class="flex justify-end gap-3">
                <button onclick="closeDetailModal()" class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 font-black text-slate-700">Tutup</button>
                <button id="btn_edit_from_detail" class="px-6 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black shadow-lg shadow-orange-200">Edit Detail</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-xl rounded-[2.5rem] overflow-hidden shadow-2xl">
        {{-- Header --}}
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-black text-slate-800">Edit Member</h3>
                <p class="text-sm text-slate-400">Perbarui informasi member gym.</p>
            </div>
            <button onclick="closeEditModal()" class="w-10 h-10 rounded-xl hover:bg-slate-100 text-slate-400"><i class="fas fa-times"></i></button>
        </div>
        {{-- Form --}}
        <form id="editForm" method="POST">
            @csrf
            <div class="p-8 space-y-6">
                <div>
                    <label class="block text-sm font-black text-slate-600 mb-3">Nama Member</label>
                    <input type="text" name="name" id="edit_name" required class="w-full rounded-2xl border border-slate-200 px-5 py-4 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-black text-slate-600 mb-3">WhatsApp</label>
                    <input type="text" name="whatsapp" id="edit_whatsapp" required class="w-full rounded-2xl border border-slate-200 px-5 py-4 focus:ring-2 focus:ring-orange-500 focus:outline-none">
                </div>
            </div>
            {{-- Footer --}}
            <div class="px-8 py-6 bg-slate-50 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-6 py-3 rounded-2xl bg-slate-200 hover:bg-slate-300 font-black text-slate-700">Batal</button>
                <button type="submit" class="px-6 py-3 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black shadow-lg shadow-orange-200">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
// Detail Modal
function openDetailModal(member) {
    document.getElementById('detailModal').classList.remove('hidden'); document.getElementById('detailModal').classList.add('flex');
    document.getElementById('detail_avatar').innerText = member.name.charAt(0).toUpperCase();
    document.getElementById('detail_name').innerText = member.name;
    document.getElementById('detail_code').innerText = member.member_code ?? 'NON MEMBER';
    document.getElementById('detail_whatsapp').innerText = member.whatsapp;
    document.getElementById('detail_package').innerText = member.package;
    document.getElementById('detail_expired').innerText = member.expired;
    document.getElementById('detail_package_status').innerText = member.package_status;
    document.getElementById('detail_visit').innerText = member.visit;
    document.getElementById('detail_streak').innerText = member.streak;
    document.getElementById('detail_pt').innerText = member.pt;
    const statusBadge = document.getElementById('detail_member_status');
    statusBadge.innerText = member.is_member ? 'MEMBER' : 'NON MEMBER';
    statusBadge.className = member.is_member ? 'bg-green-400 text-green-950 px-4 py-1 rounded-full text-xs font-black' : 'bg-red-400 text-red-950 px-4 py-1 rounded-full text-xs font-black';
    document.getElementById('btn_edit_from_detail').onclick = () => { closeDetailModal(); openEditModal(member.id, member.name, member.whatsapp); };
}
function closeDetailModal() { document.getElementById('detailModal').classList.remove('flex'); document.getElementById('detailModal').classList.add('hidden'); }

// Edit Modal
function openEditModal(id, name, whatsapp) {
    document.getElementById('editModal').classList.remove('hidden'); document.getElementById('editModal').classList.add('flex');
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_whatsapp').value = whatsapp;
    document.getElementById('editForm').action = `/admin/data/members/update/${id}`;
}
function closeEditModal() { document.getElementById('editModal').classList.remove('flex'); document.getElementById('editModal').classList.add('hidden'); }

// Backdrop Click
document.getElementById('detailModal').addEventListener('click', e => e.target === this && closeDetailModal());
document.getElementById('editModal').addEventListener('click', e => e.target === this && closeEditModal());
</script>
@endsection