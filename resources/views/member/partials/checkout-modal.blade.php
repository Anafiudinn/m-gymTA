{{-- =========================================================
    CHECKOUT MODAL
========================================================= --}}
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
        padding:16px;
    ">

    {{-- CARD --}}
    <div style="
        width:100%;
        max-width:500px;
        background:#111;
        border:1px solid #222;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 20px 50px rgba(0,0,0,.45);
    ">

        {{-- HEADER --}}
        <div style="
            padding:18px 20px;
            border-bottom:1px solid #222;
            display:flex;
            justify-content:space-between;
            align-items:center;
        ">

            <div>
                <p style="
                    margin:0;
                    color:#666;
                    font-size:10px;
                    text-transform:uppercase;
                    letter-spacing:.12em;
                    font-weight:700;
                ">
                    Checkout Paket
                </p>

                <h3 id="checkoutPackageName"
                    style="
                        margin:5px 0 0;
                        color:#fff;
                        font-size:22px;
                        font-weight:900;
                        line-height:1.1;
                        font-family:'Barlow Condensed',sans-serif;
                        text-transform:uppercase;
                    ">
                    Paket
                </h3>
            </div>

            <button onclick="closeCheckoutModal()"
                type="button"
                style="
                    width:36px;
                    height:36px;
                    border:none;
                    border-radius:10px;
                    background:#1a1a1a;
                    color:#777;
                    cursor:pointer;
                    flex-shrink:0;
                ">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div style="padding:20px;">

            {{-- TOTAL --}}
            <div style="
                margin-bottom:18px;
                padding:16px 18px;
                background:#161616;
                border:1px solid #222;
                border-radius:14px;
            ">
                <p style="
                    margin:0 0 4px;
                    color:#666;
                    font-size:11px;
                    text-transform:uppercase;
                    letter-spacing:.08em;
                ">
                    Total Pembayaran
                </p>

                <h2 id="checkoutPrice"
                    style="
                        margin:0;
                        color:#ef4444;
                        font-size:34px;
                        line-height:1;
                        font-weight:900;
                        font-family:'Bebas Neue',sans-serif;
                    ">
                    Rp 0
                </h2>
            </div>

            {{-- INFO REKENING --}}
            <div style="
                background:#161616;
                border:1px solid #222;
                border-radius:14px;
                padding:16px;
                margin-bottom:20px;
            ">

                <p style="
                    margin:0 0 14px;
                    color:#888;
                    font-size:10px;
                    text-transform:uppercase;
                    letter-spacing:.08em;
                    font-weight:700;
                ">
                    Transfer Ke Rekening
                </p>

                {{-- ITEM --}}
                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    margin-bottom:10px;
                    gap:10px;
                ">
                    <span style="color:#666; font-size:13px;">
                        Bank
                    </span>

                    <strong style="color:#fff; font-size:13px;">
                        {{ $settings['bank_name'] ?? '-' }}
                    </strong>
                </div>

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    margin-bottom:10px;
                    gap:10px;
                ">
                    <span style="color:#666; font-size:13px;">
                        No. Rekening
                    </span>

                    <strong style="
                        color:#fff;
                        font-size:13px;
                        font-family:monospace;
                    ">
                        {{ $settings['bank_number'] ?? '-' }}
                    </strong>
                </div>

                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    gap:10px;
                ">
                    <span style="color:#666; font-size:13px;">
                        Atas Nama
                    </span>

                    <strong style="
                        color:#fff;
                        font-size:13px;
                        text-align:right;
                    ">
                        {{ $settings['bank_holder'] ?? '-' }}
                    </strong>
                </div>

            </div>

            {{-- FORM --}}
            <form action="{{ route('member.package.store') }}"
                method="POST"
                enctype="multipart/form-data"
                onsubmit="return confirm('Apakah Anda yakin data transfer sudah benar?')">

                @csrf

                {{-- HIDDEN --}}
                <input type="hidden" name="type" id="checkoutType">
                <input type="hidden" name="package_id" id="checkoutPackageId">
                <input type="hidden" name="amount" id="checkoutAmount">

                {{-- BANK --}}
                <div style="margin-bottom:14px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        color:#fff;
                        font-size:12px;
                        font-weight:700;
                    ">
                        Bank Pengirim
                    </label>

                    <select name="sender_bank"
                        required
                        style="
                            width:100%;
                            height:48px;
                            background:#161616;
                            border:1px solid #222;
                            border-radius:12px;
                            padding:0 14px;
                            color:#fff;
                            outline:none;
                        ">

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
                <div style="margin-bottom:14px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        color:#fff;
                        font-size:12px;
                        font-weight:700;
                    ">
                        Nama Pengirim
                    </label>

                    <input type="text"
                        name="sender_name"
                        required
                        placeholder="Nama pemilik rekening"
                        style="
                            width:100%;
                            height:48px;
                            background:#161616;
                            border:1px solid #222;
                            border-radius:12px;
                            padding:0 14px;
                            color:#fff;
                            outline:none;
                        ">
                </div>

                {{-- REKENING --}}
                <div style="margin-bottom:14px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        color:#fff;
                        font-size:12px;
                        font-weight:700;
                    ">
                        Nomor Rekening / E-Wallet
                    </label>

                    <input type="text"
                        name="sender_account"
                        required
                        placeholder="0812xxxx / 123xxxx"
                        style="
                            width:100%;
                            height:48px;
                            background:#161616;
                            border:1px solid #222;
                            border-radius:12px;
                            padding:0 14px;
                            color:#fff;
                            outline:none;
                        ">
                </div>

                {{-- FILE --}}
                <div style="margin-bottom:20px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        color:#fff;
                        font-size:12px;
                        font-weight:700;
                    ">
                        Upload Bukti Transfer
                    </label>

                    <input type="file"
                        name="proof_attachment"
                        required
                        accept="image/*"
                        style="
                            width:100%;
                            background:#161616;
                            border:1px dashed #333;
                            border-radius:12px;
                            padding:12px;
                            color:#888;
                            font-size:13px;
                        ">
                </div>

                {{-- BUTTON --}}
                <button type="submit"
                    style="
                        width:100%;
                        height:50px;
                        border:none;
                        border-radius:12px;
                        background:#ef4444;
                        color:#fff;
                        font-size:13px;
                        font-weight:900;
                        letter-spacing:.08em;
                        cursor:pointer;
                    ">
                    KIRIM PEMBAYARAN
                </button>

            </form>
        </div>
    </div>
</div>