<div id="reuploadModal"
     style="position:fixed;inset:0;background:rgba(0,0,0,.75);backdrop-filter:blur(6px);display:none;align-items:center;justify-content:center;z-index:10000;padding:12px;">

    <div style="width:100%;max-width:420px;background:#111;border:1px solid #222;border-radius:14px;overflow:hidden;max-height:calc(100vh - 24px);display:flex;flex-direction:column;">

        {{-- HEADER --}}
        <div style="padding:13px 16px;border-bottom:1px solid #222;display:flex;justify-content:space-between;align-items:center;flex-shrink:0;">
            <div>
                <p style="margin:0;color:#666;font-size:9px;text-transform:uppercase;letter-spacing:1px;">Perbaiki Pembayaran</p>
                <h3 id="reuploadPackageName" style="margin:3px 0 0;color:#fff;font-size:17px;font-weight:900;">Paket</h3>
            </div>
            <button onclick="closeReuploadModal()" type="button"
                    style="width:30px;height:30px;border:none;border-radius:8px;background:#1a1a1a;color:#777;cursor:pointer;font-size:13px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div style="padding:14px 16px;overflow-y:auto;flex:1;">

            {{-- TOTAL --}}
            <div style="margin-bottom:12px;">
                <p style="margin:0 0 3px;color:#666;font-size:10px;">Total Pembayaran</p>
                <h2 id="reuploadAmount" style="margin:0;color:#ef4444;font-size:28px;font-weight:900;">Rp 0</h2>
            </div>

            {{-- INFO TRANSAKSI --}}
            <div style="background:#161616;border:1px solid #222;border-radius:10px;padding:12px 14px;margin-bottom:10px;">
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                    <span style="color:#666;font-size:12px;">Invoice</span>
                    <strong id="reuploadInvoice" style="color:#fff;font-size:12px;">INV</strong>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:10px;padding-bottom:10px;border-bottom:1px solid #222;">
                    <span style="color:#666;font-size:12px;">Status</span>
                    <strong style="color:#ef4444;font-weight:900;font-size:12px;">DITOLAK</strong>
                </div>
                <div>
                    <p style="margin:0 0 4px;font-size:10px;font-weight:800;color:#ef4444;text-transform:uppercase;letter-spacing:.05em;">Alasan Penolakan:</p>
                    <p id="reuploadReason" style="margin:0;color:#aaa;font-size:12px;line-height:1.5;">-</p>
                </div>
            </div>

            {{-- REKENING TUJUAN --}}
            <div style="background:#161616;border:1px solid #222;border-radius:10px;padding:12px 14px;margin-bottom:14px;">
                <p style="margin:0 0 10px;color:#888;font-size:9px;text-transform:uppercase;letter-spacing:0.5px;">Transfer Ke Rekening</p>
                <div style="display:flex;justify-content:space-between;margin-bottom:7px;">
                    <span style="color:#666;font-size:12px;">Bank</span>
                    <strong style="color:#fff;font-size:12px;">{{ $settings['bank_name'] ?? '-' }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:7px;">
                    <span style="color:#666;font-size:12px;">No. Rekening</span>
                    <strong style="color:#fff;font-size:12px;">{{ $settings['bank_number'] ?? '-' }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;">
                    <span style="color:#666;font-size:12px;">Atas Nama</span>
                    <strong style="color:#fff;font-size:12px;">{{ $settings['bank_holder'] ?? '-' }}</strong>
                </div>
            </div>

            <form id="reuploadForm" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="margin-bottom:10px;">
        <label style="display:block;margin-bottom:5px;color:#fff;font-size:11px;font-weight:700;">
            Bank Pengirim
        </label>

        <select id="reuploadSenderBank"
                name="sender_bank"
                required
                style="width:100%;height:40px;background:#161616;border:1px solid #222;border-radius:9px;padding:0 12px;color:#fff;font-size:13px;">

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

    <div style="margin-bottom:10px;">
        <label style="display:block;margin-bottom:5px;color:#fff;font-size:11px;font-weight:700;">
            Nama Pengirim
        </label>

        <input id="reuploadSenderName"
               type="text"
               name="sender_name"
               required
               placeholder="Nama pemilik rekening"
               style="width:100%;height:40px;background:#161616;border:1px solid #222;border-radius:9px;padding:0 12px;color:#fff;font-size:13px;">
    </div>

    <div style="margin-bottom:10px;">
        <label style="display:block;margin-bottom:5px;color:#fff;font-size:11px;font-weight:700;">
            Nomor Rekening / E-Wallet
        </label>

        <input id="reuploadSenderAccount"
               type="text"
               name="sender_account"
               required
               placeholder="0812xxxx / 123xxxx"
               style="width:100%;height:40px;background:#161616;border:1px solid #222;border-radius:9px;padding:0 12px;color:#fff;font-size:13px;">
    </div>

    <div style="margin-bottom:14px;">
        <label style="display:block;margin-bottom:5px;color:#fff;font-size:11px;font-weight:700;">
            Upload Bukti Baru
        </label>

        <input type="file"
               name="proof_attachment"
               required
               accept="image/*"
               style="width:100%;background:#161616;border:1px solid #222;border-radius:9px;padding:9px 12px;color:#fff;font-size:12px;">
    </div>

    <button type="submit"
            style="width:100%;border:none;border-radius:10px;background:#ef4444;color:#fff;padding:13px;font-weight:900;cursor:pointer;font-size:13px;margin-bottom:8px;letter-spacing:0.5px;">
        KIRIM ULANG PEMBAYARAN
    </button>
</form>

        </div>
    </div>
</div>