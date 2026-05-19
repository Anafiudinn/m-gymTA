@extends('layouts.admin') {{-- Sesuaikan dengan nama layout indukmu --}}

@section('header-title', 'WhatsApp Gateway Logs')

@section('content')
@section('content')
<div class="log-container" style="padding: 20px; background: #fff; border-radius: 1px; border: 1px solid #eee; margin: 10px;">
    
    {{-- Header Menu & Form Pencarian --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; flex-wrap: wrap;">
        <div>
            <h3 style="margin: 0; font-size: 16px; color: #111;">Riwayat Pesan Gateway</h3>
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Memantau seluruh aktivitas pengiriman notifikasi otomatis dari sistem {{ $settings['gym_name'] ?? 'Satrio Gym Fitness' }}.</p>
        </div>
        
        <form action="{{ route('admin.whatsapp.logs') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, nomor, isi pesan..." 
                   style="padding: 8px 12px; font-size: 13px; border: 1px solid #ddd; border-radius: 6px; width: 220px; outline: none;">
            <button type="submit" style="background: #111; color: #fff; border: none; padding: 8px 15px; font-size: 13px; border-radius: 6px; cursor: pointer;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            @if($search)
                <a href="{{ route('admin.whatsapp.logs') }}" style="background: #eee; color: #333; border: none; padding: 8px 12px; font-size: 13px; border-radius: 6px; text-decoration: none; display: flex; align-items: center;">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Tabel Riwayat Logs --}}
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; table-layout: fixed;">
            <thead>
                <tr style="background: #f9f9f9; border-bottom: 1px solid #eee;">
                    <th style="padding: 12px; color: #555; font-weight: 600; width: 120px;">Waktu Kirim</th>
                    <th style="padding: 12px; color: #555; font-weight: 600; width: 140px;">Penerima</th>
                    <th style="padding: 12px; color: #555; font-weight: 600; width: 120px;">No. Tujuan</th>
                    <th style="padding: 12px; color: #555; font-weight: 600; width: 300px;">Isi Notifikasi</th>
                    <th style="padding: 12px; color: #555; font-weight: 600; width: 90px; text-align: center;">Status</th>
                    <th style="padding: 12px; color: #555; font-weight: 600; width: 140px;">Keterangan API</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr style="border-bottom: 1px solid #f5f5f5; vertical-align: top;">
                        <td style="padding: 12px; color: #666; font-size: 12px;">
                            {{ $log->created_at->format('d M Y') }}<br>
                            <span style="color: #999; font-size: 11px;">{{ $log->created_at->format('H:i:s') }} WIB</span>
                        </td>
                        <td style="padding: 12px; font-weight: 600; color: #333; word-wrap: break-word;">
                            {{ $log->recipient_name ?? 'System / Admin' }}
                        </td>
                        <td style="padding: 12px; color: #444; font-family: monospace;">
                            {{ $log->target }}
                        </td>
                        <td style="padding: 12px; color: #555; font-size: 12px;">
                            <div style="background: #fafafa; border-radius: 6px; padding: 8px 10px; border: 1px solid #f0f0f0;">
                                {{-- Menampilkan maksimal 90 karakter di tabel --}}
                                <span style="line-height: 1.4;">
                                    {{ Str::limit($log->message, 90, '...') }}
                                </span>
                                
                                @if(strlen($log->message) > 90)
                                    <button type="button" 
                                            onclick="openLogModal('{{ $log->recipient_name ?? 'System / Admin' }}', '{{ $log->target }}', `{!! e($log->message) !!}`)"
                                            style="display: block; margin-top: 5px; background: none; border: none; color: #22c55e; font-weight: 700; font-size: 11px; padding: 0; cursor: pointer; text-transform: uppercase; letter-spacing: 0.03em;">
                                        Lihat Detail <i class="fa-solid fa-chevron-right" style="font-size: 9px;"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            @if($log->status)
                                <span style="background: rgba(34, 197, 94, 0.1); color: #22c55e; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 12px; display: inline-block;">
                                    Sukses
                                </span>
                            @else
                                <span style="background: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 12px; display: inline-block;">
                                    Gagal
                                </span>
                            @endif
                        </td>
                        <td style="padding: 12px; font-size: 12px; color: {{ $log->status ? '#666' : '#ef4444' }}; word-wrap: break-word;">
                            {{ $log->reason }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 30px; text-align: center; color: #999;">
                            <i class="fa-regular fa-folder-open" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                            Tidak ada riwayat pengiriman WhatsApp ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Penomoran Halaman (Pagination Link) --}}
    <div style="margin-top: 20px;">
        {{ $logs->links() }}
    </div>
</div>

{{-- MODAL COMPONENT (Vanilla JS & CSS - Tanpa perlu dependensi tambahan) --}}
<div id="waLogModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center; padding: 16px; backdrop-filter: blur(2px);">
    <div style="background: #fff; width: 100%; max-width: 500px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden; animation: modalFadeIn 0.2s ease-out;">
        
        {{-- Modal Header --}}
        <div style="padding: 16px 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0; font-size: 14px; color: #111; font-weight: 700;">Detail Isi Pesan</h4>
                <p id="modalUserMeta" style="margin: 3px 0 0 0; font-size: 11px; color: #666;"></p>
            </div>
            <button onclick="closeLogModal()" style="background: none; border: none; font-size: 18px; color: #999; cursor: pointer; padding: 4px;">&times;</button>
        </div>
        
        {{-- Modal Body --}}
        <div style="padding: 20px; max-height: 400px; overflow-y: auto; background: #fafafa;">
            <div id="modalMessageContent" style="white-space: pre-line; line-height: 1.5; font-size: 12.5px; color: #333; font-family: sans-serif;"></div>
        </div>
        
        {{-- Modal Footer --}}
        <div style="padding: 12px 20px; border-top: 1px solid #eee; display: flex; justify-content: flex-end; background: #fff;">
            <button onclick="closeLogModal()" style="background: #111; color: #fff; border: none; padding: 7px 16px; font-size: 12px; font-weight: 600; border-radius: 6px; cursor: pointer;">
                Tutup
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes modalFadeIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    function openLogModal(name, target, message) {
        document.getElementById('modalUserMeta').innerHTML = `<i class="fa-solid fa-user"></i> ${name} • <span style="font-family: monospace;">${target}</span>`;
        document.getElementById('modalMessageContent').textContent = message;
        
        const modal = document.getElementById('waLogModal');
        modal.style.display = 'flex';
    }

    function closeLogModal() {
        document.getElementById('waLogModal').style.display = 'none';
    }

    // Menutup modal jika user klik area hitam di luar modal box
    window.onclick = function(event) {
        const modal = document.getElementById('waLogModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection