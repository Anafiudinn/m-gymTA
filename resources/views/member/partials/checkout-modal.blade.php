{{-- =========================================================
    CHECKOUT MODAL
========================================================= --}}
<div id="checkoutModal"
     style="position:fixed; inset:0; background:rgba(0,0,0,.75); backdrop-filter:blur(6px); display:none; align-items:center; justify-content:center; z-index:9999; padding:20px;">

    <div style="width:100%; max-width:540px; background:#111; border:1px solid #222; border-radius:22px; overflow:hidden;">

        {{-- HEADER --}}
        <div style="padding:24px; border-bottom:1px solid #222; display:flex; justify-content:space-between; align-items:center;">

            <div>
                <p style="margin:0; color:#666; font-size:11px; text-transform:uppercase; letter-spacing:1px;">
                    Checkout Paket
                </p>

                <h3 id="checkoutPackageName"
                    style="margin:4px 0 0; color:#fff; font-size:26px; font-weight:900;">
                    Paket
                </h3>
            </div>

            <button onclick="closeCheckoutModal()"
                    style="width:38px; height:38px; border:none; border-radius:10px; background:#1a1a1a; color:#777; cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div style="padding:24px;">

            {{-- TOTAL --}}
            <div style="margin-bottom:25px;">
                <p style="margin:0 0 6px; color:#666; font-size:12px;">
                    Total Pembayaran
                </p>

                <h2 id="checkoutPrice"
                    style="margin:0; color:#ef4444; font-size:42px; font-weight:900;">
                    Rp 0
                </h2>
            </div>

            {{-- INFO REKENING --}}
            <div style="background:#161616; border:1px solid #222; border-radius:14px; padding:18px; margin-bottom:24px;">

                <p style="margin:0 0 16px; color:#888; font-size:11px; text-transform:uppercase;">
                    Transfer Ke Rekening
                </p>

                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <span style="color:#666;">Bank</span>
                    <strong style="color:#fff;">BCA</strong>
                </div>

                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <span style="color:#666;">No. Rekening</span>
                    <strong style="color:#fff;">123456789</strong>
                </div>

                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#666;">Atas Nama</span>
                    <strong style="color:#fff;">UB GYM</strong>
                </div>

            </div>

            {{-- FORM --}}
            <form action="{{ route('member.package.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- HIDDEN --}}
                <input type="hidden" name="type" id="checkoutType">
                <input type="hidden" name="package_id" id="checkoutPackageId">
                <input type="hidden" name="amount" id="checkoutAmount">

                {{-- BANK --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:8px; color:#fff; font-size:12px; font-weight:700;">
                        Bank Pengirim
                    </label>

                    <select name="sender_bank"
                            required
                            style="width:100%; background:#161616; border:1px solid #222; border-radius:12px; padding:14px; color:#fff;">

                        <option value="">Pilih Bank</option>
                        <option>BCA</option>
                        <option>BRI</option>
                        <option>BNI</option>
                        <option>MANDIRI</option>
                        <option>SEABANK</option>
                        <option>DANA</option>
                        <option>OVO</option>
                        <option>GOPAY</option>
                    </select>
                </div>

                {{-- NAMA --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:8px; color:#fff; font-size:12px; font-weight:700;">
                        Nama Pengirim
                    </label>

                    <input type="text"
                           name="sender_name"
                           required
                           placeholder="Nama pemilik rekening"
                           style="width:100%; background:#161616; border:1px solid #222; border-radius:12px; padding:14px; color:#fff;">
                </div>

                {{-- NO REKENING --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block; margin-bottom:8px; color:#fff; font-size:12px; font-weight:700;">
                        Nomor Rekening / E-Wallet
                    </label>

                    <input type="text"
                           name="sender_account"
                           required
                           placeholder="0812xxxx / 123xxxx"
                           style="width:100%; background:#161616; border:1px solid #222; border-radius:12px; padding:14px; color:#fff;">
                </div>

                {{-- BUKTI --}}
                <div style="margin-bottom:24px;">
                    <label style="display:block; margin-bottom:8px; color:#fff; font-size:12px; font-weight:700;">
                        Upload Bukti Transfer
                    </label>

                    <input type="file"
                           name="proof_attachment"
                           required
                           accept="image/*"
                           style="width:100%; background:#161616; border:1px solid #222; border-radius:12px; padding:14px; color:#fff;">
                </div>

                {{-- BUTTON --}}
                <button type="submit"
                        style="width:100%; border:none; border-radius:14px; background:#ef4444; color:#fff; padding:16px; font-weight:900; cursor:pointer; font-size:14px;">
                    KIRIM PEMBAYARAN
                </button>

            </form>
        </div>
    </div>
</div>