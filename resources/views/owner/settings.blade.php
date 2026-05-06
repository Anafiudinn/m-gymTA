@extends('layouts.owner')
@section('title', 'Pengaturan Harga Master')

@section('content')
<div class="max-w-2xl bg-white p-8 rounded-lg shadow-sm">
    <form action="{{ route('owner.settings.update') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Biaya Aktivasi (Seumur Hidup)</label>
                <input type="number" name="biaya_aktivasi" value="{{ $settings['biaya_aktivasi'] ?? 80000 }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 text-blue-600">Visit Member (Sudah Aktivasi)</label>
                    <input type="number" name="visit_member" value="{{ $settings['visit_member'] ?? 7000 }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 text-red-600">Visit Tamu (Belum Aktivasi)</label>
                    <input type="number" name="visit_tamu" value="{{ $settings['visit_tamu'] ?? 15000 }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <hr>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection