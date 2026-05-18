@extends('layouts.owner')

@section('title', 'Pengaturan Sistem')
@section('header-title', 'Pengaturan Sistem')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 style="font-size:1.4rem;font-weight:800;color:var(--text);letter-spacing:-.03em;">
            Pengaturan Sistem
        </h1>
        <p style="font-size:.85rem;color:var(--muted);margin-top:4px;">
            Kelola harga paket, biaya gym, dan informasi rekening transfer.
        </p>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div style="
            background:rgba(34,197,94,.10);
            border:1px solid rgba(34,197,94,.25);
            color:#15803d;
            padding:14px 18px;
            border-radius:1px;
            font-size:.875rem;
            font-weight:600;
            display:flex;
            align-items:center;
            gap:10px;
        ">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('owner.settings.update') }}" method="POST">
        @csrf

        {{-- =============================================
             HARGA PAKET & AKTIVASI
        ============================================= --}}
        <div class="card" style="margin-bottom:20px;">

            <div style="
                display:flex;
                align-items:center;
                gap:12px;
                padding-bottom:16px;
                margin-bottom:20px;
                border-bottom:1px solid var(--border);
            ">
                <div style="
                    width:38px;height:38px;
                    border-radius:1px;
                    background:rgba(239,68,68,.10);
                    color:var(--red);
                    display:flex;align-items:center;justify-content:center;
                    font-size:15px;
                ">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <div>
                    <div style="font-size:.9rem;font-weight:800;color:var(--text);">Harga Paket & Aktivasi</div>
                    <div style="font-size:.78rem;color:var(--muted);">Atur biaya keanggotaan dan kunjungan</div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:18px;">

                {{-- Biaya Aktivasi --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-solid fa-id-card" style="color:var(--red);margin-right:6px;"></i>
                        Biaya Aktivasi Member
                    </label>
                    <div style="position:relative;">
                        <span style="
                            position:absolute;left:13px;top:50%;transform:translateY(-50%);
                            font-size:.8rem;font-weight:700;color:var(--muted);
                        ">Rp</span>
                        <input type="number"
                               name="biaya_aktivasi"
                               value="{{ $settings['biaya_aktivasi'] ?? 80000 }}"
                               style="
                                width:100%;padding:10px 12px 10px 36px;
                                border:1px solid var(--border);border-radius:1px;
                                background:var(--surface-2);
                                font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                                color:var(--text);outline:none;transition:.18s ease;
                               "
                               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                </div>

                {{-- Bulanan Member --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-solid fa-user" style="color:var(--red);margin-right:6px;"></i>
                        Paket Bulanan Member
                    </label>
                    <div style="position:relative;">
                        <span style="
                            position:absolute;left:13px;top:50%;transform:translateY(-50%);
                            font-size:.8rem;font-weight:700;color:var(--muted);
                        ">Rp</span>
                        <input type="number"
                               name="bulanan_member"
                               value="{{ $settings['bulanan_member'] ?? 110000 }}"
                               style="
                                width:100%;padding:10px 12px 10px 36px;
                                border:1px solid var(--border);border-radius:1px;
                                background:var(--surface-2);
                                font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                                color:var(--text);outline:none;transition:.18s ease;
                               "
                               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                </div>

                {{-- Bulanan Tamu --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-solid fa-user-clock" style="color:var(--red);margin-right:6px;"></i>
                        Paket Bulanan Tamu
                    </label>
                    <div style="position:relative;">
                        <span style="
                            position:absolute;left:13px;top:50%;transform:translateY(-50%);
                            font-size:.8rem;font-weight:700;color:var(--muted);
                        ">Rp</span>
                        <input type="number"
                               name="bulanan_tamu"
                               value="{{ $settings['bulanan_tamu'] ?? 200000 }}"
                               style="
                                width:100%;padding:10px 12px 10px 36px;
                                border:1px solid var(--border);border-radius:1px;
                                background:var(--surface-2);
                                font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                                color:var(--text);outline:none;transition:.18s ease;
                               "
                               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                </div>

                {{-- Visit Member --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-solid fa-person-walking" style="color:var(--red);margin-right:6px;"></i>
                        Harga Visit Member
                    </label>
                    <div style="position:relative;">
                        <span style="
                            position:absolute;left:13px;top:50%;transform:translateY(-50%);
                            font-size:.8rem;font-weight:700;color:var(--muted);
                        ">Rp</span>
                        <input type="number"
                               name="visit_member"
                               value="{{ $settings['visit_member'] ?? 7000 }}"
                               style="
                                width:100%;padding:10px 12px 10px 36px;
                                border:1px solid var(--border);border-radius:1px;
                                background:var(--surface-2);
                                font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                                color:var(--text);outline:none;transition:.18s ease;
                               "
                               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                </div>

                {{-- Visit Tamu --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-solid fa-ticket" style="color:var(--red);margin-right:6px;"></i>
                        Harga Visit Tamu
                    </label>
                    <div style="position:relative;">
                        <span style="
                            position:absolute;left:13px;top:50%;transform:translateY(-50%);
                            font-size:.8rem;font-weight:700;color:var(--muted);
                        ">Rp</span>
                        <input type="number"
                               name="visit_tamu"
                               value="{{ $settings['visit_tamu'] ?? 15000 }}"
                               style="
                                width:100%;padding:10px 12px 10px 36px;
                                border:1px solid var(--border);border-radius:1px;
                                background:var(--surface-2);
                                font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                                color:var(--text);outline:none;transition:.18s ease;
                               "
                               onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                    </div>
                </div>

            </div>
        </div>

        {{-- =============================================
             INFORMASI GYM
        ============================================= --}}
        <div class="card" style="margin-bottom:20px;">

            <div style="
                display:flex;
                align-items:center;
                gap:12px;
                padding-bottom:16px;
                margin-bottom:20px;
                border-bottom:1px solid var(--border);
            ">
                <div style="
                    width:38px;height:38px;
                    border-radius:1px;
                    background:rgba(239,68,68,.10);
                    color:var(--red);
                    display:flex;align-items:center;justify-content:center;
                    font-size:15px;
                ">
                    <i class="fa-solid fa-dumbbell"></i>
                </div>
                <div>
                    <div style="font-size:.9rem;font-weight:800;color:var(--text);">Informasi Gym</div>
                    <div style="font-size:.78rem;color:var(--muted);">Data identitas dan kontak gym</div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:18px;">

                {{-- Nama Gym --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-solid fa-building" style="color:var(--red);margin-right:6px;"></i>
                        Nama Gym
                    </label>
                    <input type="text"
                           name="gym_name"
                           value="{{ $settings['gym_name'] ?? '' }}"
                           placeholder="Contoh: UB GYM"
                           style="
                            width:100%;padding:10px 14px;
                            border:1px solid var(--border);border-radius:1px;
                            background:var(--surface-2);
                            font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                            color:var(--text);outline:none;transition:.18s ease;
                           "
                           onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                           onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                </div>

                {{-- No WhatsApp --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-brands fa-whatsapp" style="color:var(--red);margin-right:6px;"></i>
                        Nomor WhatsApp Gym
                    </label>
                    <input type="text"
                           name="gym_phone"
                           value="{{ $settings['gym_phone'] ?? '' }}"
                           placeholder="628xxx"
                           style="
                            width:100%;padding:10px 14px;
                            border:1px solid var(--border);border-radius:1px;
                            background:var(--surface-2);
                            font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                            color:var(--text);outline:none;transition:.18s ease;
                           "
                           onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                           onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                </div>
                {{-- instagram --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-brands fa-instagram" style="color:var(--red);margin-right:6px;"></i>
                        Instagram Gym
                    </label>
                    <input type="text"
                           name="gym_instagram"
                           value="{{ $settings['gym_instagram'] ?? '' }}"
                           placeholder="Contoh: @gymku"
                           style="
                            width:100%;padding:10px 14px;
                            border:1px solid var(--border);border-radius:1px;
                            background:var(--surface-2);
                            font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                            color:var(--text);outline:none;transition:.18s ease;
                           "
                           onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                           onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                </div>

                {{-- Alamat --}}
                <div style="grid-column:1/-1;">
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-solid fa-location-dot" style="color:var(--red);margin-right:6px;"></i>
                        Alamat Gym
                    </label>
                    <textarea name="gym_address"
                              rows="3"
                              placeholder="Masukkan alamat lengkap gym..."
                              style="
                               width:100%;padding:10px 14px;
                               border:1px solid var(--border);border-radius:1px;
                               background:var(--surface-2);
                               font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                               color:var(--text);outline:none;transition:.18s ease;resize:vertical;
                              "
                              onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                              onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">{{ $settings['gym_address'] ?? '' }}</textarea>
                </div>

            </div>
        </div>

        {{-- =============================================
             REKENING TRANSFER
        ============================================= --}}
        <div class="card" style="margin-bottom:28px;">

            <div style="
                display:flex;
                align-items:center;
                gap:12px;
                padding-bottom:16px;
                margin-bottom:20px;
                border-bottom:1px solid var(--border);
            ">
                <div style="
                    width:38px;height:38px;
                    border-radius:1px;
                    background:rgba(239,68,68,.10);
                    color:var(--red);
                    display:flex;align-items:center;justify-content:center;
                    font-size:15px;
                ">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <div>
                    <div style="font-size:.9rem;font-weight:800;color:var(--text);">Rekening Transfer</div>
                    <div style="font-size:.78rem;color:var(--muted);">Informasi rekening untuk pembayaran member</div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:18px;">

                {{-- Nama Bank --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-solid fa-landmark" style="color:var(--red);margin-right:6px;"></i>
                        Nama Bank
                    </label>
                    <input type="text"
                           name="bank_name"
                           value="{{ $settings['bank_name'] ?? '' }}"
                           placeholder="Contoh: BCA"
                           style="
                            width:100%;padding:10px 14px;
                            border:1px solid var(--border);border-radius:1px;
                            background:var(--surface-2);
                            font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                            color:var(--text);outline:none;transition:.18s ease;
                           "
                           onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                           onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                </div>

                {{-- Nomor Rekening --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-solid fa-credit-card" style="color:var(--red);margin-right:6px;"></i>
                        Nomor Rekening
                    </label>
                    <input type="text"
                           name="bank_number"
                           value="{{ $settings['bank_number'] ?? '' }}"
                           placeholder="Contoh: 1234567890"
                           style="
                            width:100%;padding:10px 14px;
                            border:1px solid var(--border);border-radius:1px;
                            background:var(--surface-2);
                            font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                            color:var(--text);outline:none;transition:.18s ease;
                           "
                           onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                           onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                </div>

                {{-- Atas Nama --}}
                <div>
                    <label style="display:block;font-size:.8rem;font-weight:700;color:#555;margin-bottom:8px;">
                        <i class="fa-solid fa-user-check" style="color:var(--red);margin-right:6px;"></i>
                        Atas Nama
                    </label>
                    <input type="text"
                           name="bank_holder"
                           value="{{ $settings['bank_holder'] ?? '' }}"
                           placeholder="Nama pemilik rekening"
                           style="
                            width:100%;padding:10px 14px;
                            border:1px solid var(--border);border-radius:1px;
                            background:var(--surface-2);
                            font-family:'Outfit',sans-serif;font-size:.875rem;font-weight:600;
                            color:var(--text);outline:none;transition:.18s ease;
                           "
                           onfocus="this.style.borderColor='var(--red)';this.style.boxShadow='0 0 0 3px rgba(239,68,68,.12)';"
                           onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                </div>

            </div>
        </div>

        {{-- BUTTON SIMPAN --}}
        <div style="display:flex;justify-content:flex-end;">
            <button type="submit"
                    style="
                        display:inline-flex;align-items:center;gap:10px;
                        padding:12px 28px;
                        border-radius:1px;
                        border:none;cursor:pointer;
                        background:linear-gradient(135deg,var(--red),var(--red-dark));
                        color:#fff;
                        font-family:'Outfit',sans-serif;
                        font-size:.9rem;font-weight:800;
                        box-shadow:0 6px 18px rgba(239,68,68,.30);
                        transition:.18s ease;
                    "
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 24px rgba(239,68,68,.40)';"
                    onmouseout="this.style.transform='';this.style.boxShadow='0 6px 18px rgba(239,68,68,.30)';">
                <i class="fa-solid fa-floppy-disk"></i>
                Simpan Pengaturan
            </button>
        </div>

    </form>

</div>

@endsection