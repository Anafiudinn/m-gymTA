@extends('layouts.owner')

@section('title', 'Pengaturan Sistem')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Pengaturan Sistem
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Kelola harga paket, biaya gym, dan informasi rekening transfer.
        </p>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('owner.settings.update') }}"
          method="POST"
          class="space-y-6">

        @csrf

        {{-- =========================================
             HARGA PAKET
        ========================================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="font-semibold text-gray-700">
                    Harga Paket & Aktivasi
                </h2>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Aktivasi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Biaya Aktivasi Member
                    </label>

                    <input type="number"
                           name="biaya_aktivasi"
                           value="{{ $settings['biaya_aktivasi'] ?? 80000 }}"
                           class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">
                </div>

                {{-- Bulanan Member --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Paket Bulanan Member
                    </label>

                    <input type="number"
                           name="bulanan_member"
                           value="{{ $settings['bulanan_member'] ?? 110000 }}"
                           class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">
                </div>

                {{-- Bulanan Tamu --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Paket Bulanan Tamu
                    </label>

                    <input type="number"
                           name="bulanan_tamu"
                           value="{{ $settings['bulanan_tamu'] ?? 200000 }}"
                           class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">
                </div>

                {{-- Visit Member --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Harga Visit Member
                    </label>

                    <input type="number"
                           name="visit_member"
                           value="{{ $settings['visit_member'] ?? 7000 }}"
                           class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">
                </div>

                {{-- Visit Tamu --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Harga Visit Tamu
                    </label>

                    <input type="number"
                           name="visit_tamu"
                           value="{{ $settings['visit_tamu'] ?? 15000 }}"
                           class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">
                </div>

            </div>
        </div>

        {{-- =========================================
             INFORMASI GYM
        ========================================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="font-semibold text-gray-700">
                    Informasi Gym
                </h2>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Gym --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Gym
                    </label>

                    <input type="text"
                           name="gym_name"
                           value="{{ $settings['gym_name'] ?? '' }}"
                           class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">
                </div>

                {{-- No HP --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor WhatsApp Gym
                    </label>

                    <input type="text"
                           name="gym_phone"
                           value="{{ $settings['gym_phone'] ?? '' }}"
                           class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">
                </div>

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Gym
                    </label>

                    <textarea name="gym_address"
                              rows="3"
                              class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">{{ $settings['gym_address'] ?? '' }}</textarea>
                </div>

            </div>
        </div>

        {{-- =========================================
             REKENING TRANSFER
        ========================================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="font-semibold text-gray-700">
                    Rekening Transfer
                </h2>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Bank --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Bank
                    </label>

                    <input type="text"
                           name="bank_name"
                           value="{{ $settings['bank_name'] ?? '' }}"
                           class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">
                </div>

                {{-- Nomor Rekening --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Rekening
                    </label>

                    <input type="text"
                           name="bank_number"
                           value="{{ $settings['bank_number'] ?? '' }}"
                           class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">
                </div>

                {{-- Atas Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Atas Nama
                    </label>

                    <input type="text"
                           name="bank_holder"
                           value="{{ $settings['bank_holder'] ?? '' }}"
                           class="w-full rounded-xl border-gray-300 focus:ring focus:ring-blue-200">
                </div>

            </div>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-sm">

                Simpan Pengaturan

            </button>
        </div>
    </form>
</div>

@endsection