{{-- =========================================================
    REUPLOAD PAYMENT MODAL (Lengkap dengan Rekening Penerima)
========================================================= --}}
<div id="reuploadModal"
     style="position:fixed; inset:0; background:rgba(0,0,0,.75); backdrop-filter:blur(6px); display:none; align-items:center; justify-content:center; z-index:10000; padding:20px;">

    <div style="width:100%; max-width:540px; background:#111; border:1px solid #222; border-radius:22px; overflow:hidden;">

        {{-- HEADER --}}
        <div style="padding:24px; border-bottom:1px solid #222; display:flex; justify-content:space-between; align-items:center;">
            <div>
                <p style="margin:0; color:#666; font-size:11px; text-transform:uppercase; letter-spacing:1px;">
                    Perbaiki Pembayaran
                </p>
                <h3 id="reuploadPackageName" style="margin:4px 0 0; color:#fff; font-size:26px; font-weight:900;">
                    Paket
                </h3>
            </div>

            <button onclick="closeReuploadModal()" type="button"
                    style="width:38px; height:38px; border:none; border-radius:10px; background:#1a1a1a; color:#777; cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div style="padding:24px; max-height:calc(100vh - 150px); overflow-y:auto;">

            {{-- TOTAL --}}
            <div style="margin-bottom:25px;">
                <p style="margin:0 0 6px; color:#666; font-size:12px;">
                    Total Pembayaran
                </p>
                <h2 id="reuploadAmount" style="margin:0; color:#ef4444; font-size:42px; font-weight:900;">
                    Rp 0
                </h2>
            </div>

            {{-- 1. INFO TRANSAKSI & REJECTION REASON --}}
            <div style="background:#161616; border:1px solid #222; border-radius:14px; padding:18px; margin-bottom:16px;">
                <div style="display:flex; justify-content:space-between; margin-bottom:12px;">
                    <span style="color:#666; font-size:13px;">Invoice</span>
                    <strong id="reuploadInvoice" style="color:#fff;">INV</strong>
                </div>

                <div style="display:flex; justify-content:space-between; margin-bottom:14px; padding-bottom:14px; border-bottom:1px solid #222;">
                    <span style="color:#666; font-size:13px;">Status</span>
                    <strong style="color:#ef4444; font-weight:900;">DITOLAK</strong>
                </div>

                <div>
                    <p style="margin:0 0 6px; font-size:11px; font-weight:800; color:#ef4444; text-transform:uppercase; letter-spacing:.05em;">
                        Alasan Penolakan:
                    </p>
                    <p id="reuploadReason" style="margin:0; color:#aaa; font-size:13px; line-height:1.5;">
                        -
                    </p>
                </div>
            </div>

            {{-- 2. INFO REKENING TUJUAN (DATA PENERIMA/ADMIN) --}}
            <div style="background:#161616; border:1px solid #222; border-radius:14px; padding:18px; margin-bottom:24px;">
                <p style="margin:0 0 16px; color:#888; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">
                    Transfer Ke Rekening (Penerima)
                </p>

                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <span style="color:#666; font-size:13px;">Bank</span>
                    <strong style="color:#fff;">{{ $settings['bank_name'] ?? '-' }}</strong>
                </div>

                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <span style="color:#666; font-size:13px;">No. Rekening</span>
                    <strong style="color:#fff;">{{ $settings['bank_number'] ?? '-' }}</strong>
                </div>

                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#666; font-size:13px;">Atas Nama</span>
                    <strong style="color:#fff;">{{ $settings['bank_holder'] ?? '-' }}</strong>
                </div>
            </div>

            {{-- FORM --}}
            <form id="reuploadForm" method="POST" enctype="multipart/form-data"
                  onsubmit="return confirm('Apakah Anda yakin ingin mengirim ulang bukti pembayaran ini? Pastikan foto bukti yang baru sudah jelas.');">
                @csrf
                @method('PUT')

                {{-- BANK PENGIRIM --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:8px; color:#fff; font-size:12px; font-weight:700;">
                        Bank Pengirim Anda
                    </label>

                    <select name="sender_bank" required
                            style="width:100%; background:#161616; border:1px solid #222; border-radius:12px; padding:14px; color:#fff;">
                        <option value="">Pilih Bank</option>
                        <option value="BCA">BCA</option>
                        <option value="BRI">BRI</option>
                        <option value="BNI">BNI</option>
                        <option value="MANDIRI">MANDIRI</option>
                        <option value="SEABANK">SEABANK</option>
                        <option value="DANA">DANA</option>
                        <option value="OVO">OVO</option>
                        <option value="GOPAY">GOPAY</option>
                    </select>
                </div>

                {{-- NAMA REKENING PENGIRIM --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:8px; color:#fff; font-size:12px; font-weight:700;">
                        Nama Pengirim
                    </label>

                    <input type="text" name="sender_name" required placeholder="Nama pemilik rekening"
                           style="width:100%; background:#161616; border:1px solid #222; border-radius:12px; padding:14px; color:#fff;">
                </div>

                {{-- NOMOR REKENING PENGIRIM --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:8px; color:#fff; font-size:12px; font-weight:700;">
                        Nomor Rekening / E-Wallet
                    </label>

                    <input type="text" name="sender_account" required placeholder="0812xxxx / 123xxxx"
                           style="width:100%; background:#161616; border:1px solid #222; border-radius:12px; padding:14px; color:#fff;">
                </div>

                {{-- UPLOAD BUKTI BARU --}}
                <div style="margin-bottom:24px;">
                    <label style="display:block; margin-bottom:8px; color:#fff; font-size:12px; font-weight:700;">
                        Upload Bukti Baru
                    </label>

                    <input type="file" name="proof_attachment" required accept="image/*"
                           style="width:100%; background:#161616; border:1px solid #222; border-radius:12px; padding:14px; color:#fff;">
                </div>

                {{-- BUTTON KIRIM --}}
                <button type="submit"
                        style="width:100%; border:none; border-radius:14px; background:#ef4444; color:#fff; padding:16px; font-weight:900; cursor:pointer; font-size:14px; margin-bottom:14px; letter-spacing:0.5px;">
                    KIRIM ULANG PEMBAYARAN
                </button>

                {{-- CHAT ADMIN --}}
                <a href="https://wa.me/6281234567890" target="_blank"
                   style="width:100%; display:flex; align-items:center; justify-content:center; gap:10px; padding:14px; border-radius:14px; border:1px solid #222; background:#161616; color:#888; text-decoration:none; font-weight:700; font-size:13px;">
                    <i class="fa-brands fa-whatsapp"></i>
                    Chat Admin
                </a>
            </form>

        </div>
    </div>
</div>