<div id="checkoutModal"
    style="
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.78);
        backdrop-filter:blur(5px);
        display:none;
        align-items:center;
        justify-content:center;
        z-index:9999;
        padding:12px;
    ">

    <div style="
        width:100%;
        max-width:420px;
        background:#111;
        border:1px solid #222;
        border-radius:14px;
        overflow:hidden;
        max-height:calc(100vh - 24px);
        display:flex;
        flex-direction:column;
    ">

        {{-- HEADER --}}
        <div style="
            padding:13px 16px;
            border-bottom:1px solid #222;
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-shrink:0;
        ">
            <div>
                <p style="margin:0;color:#666;font-size:9px;text-transform:uppercase;letter-spacing:.12em;font-weight:700;">
                    Checkout Paket
                </p>
                <h3 id="checkoutPackageName" style="margin:3px 0 0;color:#fff;font-size:17px;font-weight:900;line-height:1.1;font-family:'Barlow Condensed',sans-serif;text-transform:uppercase;">
                    Paket
                </h3>
            </div>
            <button onclick="closeCheckoutModal()" type="button" style="width:30px;height:30px;border:none;border-radius:8px;background:#1a1a1a;color:#777;cursor:pointer;font-size:13px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div style="padding:14px 16px;overflow-y:auto;flex:1;">

            {{-- TOTAL --}}
            <div style="margin-bottom:12px;padding:11px 14px;background:#161616;border:1px solid #222;border-radius:10px;">
                <p style="margin:0 0 2px;color:#666;font-size:10px;text-transform:uppercase;letter-spacing:.08em;">
                    Total Pembayaran
                </p>
                <h2 id="checkoutPrice" style="margin:0;color:#ef4444;font-size:26px;line-height:1;font-weight:900;font-family:'Bebas Neue',sans-serif;">
                    Rp 0
                </h2>
            </div>

            {{-- INFO REKENING --}}
            <div style="background:#161616;border:1px solid #222;border-radius:10px;padding:11px 14px;margin-bottom:14px;">
                <p style="margin:0 0 10px;color:#888;font-size:9px;text-transform:uppercase;letter-spacing:.08em;font-weight:700;">
                    Transfer Ke Rekening
                </p>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px;gap:8px;">
                    <span style="color:#666;font-size:12px;">Bank</span>
                    <strong style="color:#fff;font-size:12px;">{{ $settings['bank_name'] ?? '-' }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px;gap:8px;">
                    <span style="color:#666;font-size:12px;">No. Rekening</span>
                    <strong style="color:#fff;font-size:12px;font-family:monospace;">{{ $settings['bank_number'] ?? '-' }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;gap:8px;">
                    <span style="color:#666;font-size:12px;">Atas Nama</span>
                    <strong style="color:#fff;font-size:12px;text-align:right;">{{ $settings['bank_holder'] ?? '-' }}</strong>
                </div>
            </div>

            {{-- FORM --}}
            <form action="{{ route('member.package.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" id="checkoutType">
                <input type="hidden" name="package_id" id="checkoutPackageId">
                <input type="hidden" name="amount" id="checkoutAmount">

                {{-- BANK --}}
                <div style="margin-bottom:10px;">
                    <label style="display:block;margin-bottom:5px;color:#fff;font-size:11px;font-weight:700;">Bank Pengirim</label>
                    <select name="sender_bank" required style="width:100%;height:40px;background:#161616;border:1px solid #222;border-radius:9px;padding:0 12px;color:#fff;outline:none;font-size:13px;">
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

                {{-- NAMA --}}
                <div style="margin-bottom:10px;">
                    <label style="display:block;margin-bottom:5px;color:#fff;font-size:11px;font-weight:700;">Nama Pengirim</label>
                    <input type="text" name="sender_name" required placeholder="Nama pemilik rekening"
                        style="width:100%;height:40px;background:#161616;border:1px solid #222;border-radius:9px;padding:0 12px;color:#fff;outline:none;font-size:13px;">
                </div>

                {{-- REKENING --}}
                <div style="margin-bottom:10px;">
                    <label style="display:block;margin-bottom:5px;color:#fff;font-size:11px;font-weight:700;">Nomor Rekening / E-Wallet</label>
                    <input type="text" name="sender_account" required placeholder="0812xxxx / 123xxxx"
                        style="width:100%;height:40px;background:#161616;border:1px solid #222;border-radius:9px;padding:0 12px;color:#fff;outline:none;font-size:13px;">
                </div>

                {{-- FILE --}}
                <div style="margin-bottom:14px;">
                    <label style="display:block;margin-bottom:5px;color:#fff;font-size:11px;font-weight:700;">Upload Bukti Transfer</label>
                    <input type="file" name="proof_attachment" required accept="image/*"
                        style="width:100%;background:#161616;border:1px dashed #333;border-radius:9px;padding:9px 12px;color:#888;font-size:12px;">
                </div>

                {{-- BUTTON --}}
                <button type="submit" style="width:100%;height:44px;border:none;border-radius:9px;background:#ef4444;color:#fff;font-size:12px;font-weight:900;letter-spacing:.08em;cursor:pointer;">
                    KIRIM PEMBAYARAN
                </button>
            </form>
        </div>
    </div>
</div>