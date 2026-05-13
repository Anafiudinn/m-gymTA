@extends('layouts.owner')
@section('title', 'Paket PT')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-5">
    <div>
        <h1 class="text-[18px] font-bold text-gray-900">Paket PT</h1>
        <p class="text-[13px] text-gray-400 mt-1">
            Total Paket: {{ $totalPackages }}
        </p>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="w-full lg:w-[280px]">
        <div class="relative">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari paket / coach..."
                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-[13px]
                       focus:outline-none focus:border-gray-400 transition">

            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </div>
    </form>
</div>

{{-- FORM TAMBAH --}}
<div class="bg-white border border-gray-100 rounded-2xl p-5 mb-5">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-[14px] font-semibold text-gray-900">
                Tambah Paket PT
            </h2>
            <p class="text-[12px] text-gray-400 mt-1">
                Tambahkan paket personal trainer baru
            </p>
        </div>
    </div>

    <form
        action="{{ route('owner.pt-packages.store') }}"
        method="POST"
        id="form-add-package"
        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
        @csrf

        {{-- NAMA --}}
        <div>
            <label class="block text-[12px] font-medium text-gray-500 mb-1.5">
                Nama Paket
            </label>

            <input
                type="text"
                name="nama_paket"
                value="{{ old('nama_paket') }}"
                placeholder="Paket 10 Sesi"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-[13px]
                       focus:outline-none focus:border-gray-400 transition"
                required>
        </div>

        {{-- SESI --}}
        <div>
            <label class="block text-[12px] font-medium text-gray-500 mb-1.5">
                Jumlah Sesi
            </label>

            <input
                type="number"
                name="jumlah_sesi"
                value="{{ old('jumlah_sesi') }}"
                min="1"
                placeholder="10"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-[13px]
                       focus:outline-none focus:border-gray-400 transition"
                required>
        </div>

        {{-- HARGA --}}
        <div>
            <label class="block text-[12px] font-medium text-gray-500 mb-1.5">
                Harga
            </label>

            <input
                type="number"
                name="harga"
                value="{{ old('harga') }}"
                min="0"
                placeholder="900000"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-[13px]
                       focus:outline-none focus:border-gray-400 transition"
                required>
        </div>

        {{-- COACH --}}
        <div>
            <label class="block text-[12px] font-medium text-gray-500 mb-1.5">
                Nama Coach
            </label>

            <input
                type="text"
                name="coach_name"
                value="{{ old('coach_name') }}"
                placeholder="Coach John"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-[13px]
                       focus:outline-none focus:border-gray-400 transition">
        </div>

        {{-- WA --}}
        <div>
            <label class="block text-[12px] font-medium text-gray-500 mb-1.5">
                WhatsApp Coach
            </label>

            <input
                type="text"
                name="coach_whatsapp"
                value="{{ old('coach_whatsapp') }}"
                placeholder="08123456789"
                class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-[13px]
                       focus:outline-none focus:border-gray-400 transition">
        </div>

        {{-- BUTTON --}}
        <div class="md:col-span-2 xl:col-span-5">
            <button
                type="submit"
                id="btn-add-package"
                class="bg-gray-900 hover:bg-black active:scale-[.98]
                       text-white text-[13px] font-medium
                       px-5 py-2.5 rounded-xl transition">
                + Tambah Paket
            </button>
        </div>
    </form>
</div>

{{-- TABLE --}}
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="text-[14px] font-semibold text-gray-900">
            Daftar Paket PT
        </h2>
    </div>

    @if($packages->count() == 0)

    <div class="py-16 text-center">
        <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-gray-300"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="1.5">
                <path d="M4 7h16M4 12h16M4 17h10" />
            </svg>
        </div>

        <p class="text-[13px] text-gray-400">
            Belum ada paket PT
        </p>
    </div>

    @else

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase">
                        Paket
                    </th>

                    <th class="px-5 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase">
                        Sesi
                    </th>

                    <th class="px-5 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase">
                        Harga
                    </th>

                    <th class="px-5 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase">
                        Coach
                    </th>

                    <th class="px-5 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase">
                        Status
                    </th>

                    <th class="px-5 py-3 text-right text-[11px] font-semibold text-gray-400 uppercase">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">

                @foreach($packages as $package)

                <tr class="hover:bg-gray-50/70 transition">

                    {{-- PAKET --}}
                    <td class="px-5 py-4">
                        <div class="text-[13px] font-semibold text-gray-900">
                            {{ $package->nama_paket }}
                        </div>

                        <div class="text-[12px] text-gray-400 mt-0.5">
                            ID #{{ $package->id }}
                        </div>
                    </td>

                    {{-- SESI --}}
                    <td class="px-5 py-4">
                        <span class="text-[13px] text-gray-700">
                            {{ $package->jumlah_sesi }} sesi
                        </span>
                    </td>

                    {{-- HARGA --}}
                    <td class="px-5 py-4">
                        <span class="text-[13px] font-semibold text-gray-900">
                            Rp {{ number_format($package->harga, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- COACH --}}
                    <td class="px-5 py-4">
                        @if($package->coach_name)

                        <div class="text-[13px] font-medium text-gray-800">
                            {{ $package->coach_name }}
                        </div>

                        @if($package->coach_whatsapp)
                        <a
                            href="https://wa.me/{{ preg_replace('/\D/', '', $package->coach_whatsapp) }}"
                            target="_blank"
                            class="text-[12px] text-green-600 hover:underline">
                            {{ $package->coach_whatsapp }}
                        </a>
                        @endif

                        @else

                        <span class="text-[12px] italic text-gray-400">
                            Tidak ada coach
                        </span>

                        @endif
                    </td>

                    {{-- STATUS --}}
                    <td class="px-5 py-4">
                        @if($package->is_active)

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Aktif
                        </span>

                        @else

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 text-[11px] font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            Nonaktif
                        </span>

                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">

                            {{-- TOGGLE --}}
                            {{-- TOGGLE --}}
                            <form
                                action="{{ route('owner.pt-packages.toggle', $package->id) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="text-[12px] px-3 py-1.5 rounded-lg border transition
            {{ $package->is_active
                ? 'border-orange-200 text-orange-600 hover:bg-orange-50'
                : 'border-emerald-200 text-emerald-600 hover:bg-emerald-50'
            }}">
                                    {{ $package->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            {{-- DELETE --}}
                            <form
                                action="{{ route('owner.pt-packages.delete', $package->id) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus paket ini?')">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="text-[12px] px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition">
                                    Hapus
                                </button>
                            </form>


                        </div>
                    </td>

                </tr>

                @endforeach

            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $packages->links() }}
    </div>

    @endif
</div>

<script>
    const formPkg = document.getElementById('form-add-package');
    const btnPkg = document.getElementById('btn-add-package');

    formPkg.addEventListener('submit', function() {
        btnPkg.disabled = true;
        btnPkg.innerHTML = 'Menyimpan...';
    });
</script>

@endsection