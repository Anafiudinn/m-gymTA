{{-- CHECKOUT MODAL --}}
<div id="checkoutModal"
     style="position:fixed; inset:0; background:rgba(0,0,0,.7); backdrop-filter:blur(4px); display:none; align-items:center; justify-content:center; z-index:9999; padding:20px;">

    <div style="width:100%; max-width:520px; background:var(--bg2); border:1px solid var(--border); border-radius:18px; overflow:hidden; animation:modalPop .2s ease;">

        <div style="padding:22px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:.12em; margin:0 0 4px;">
                    Checkout Paket
                </p>

                <h3 id="checkoutPackageName"
                    style="font-size:24px; font-weight:900; margin:0;">
                    Paket
                </h3>
            </div>

            <button onclick="closeCheckoutModal()"
                    type="button"
                    style="width:36px; height:36px; border:none; border-radius:10px; background:rgba(255,255,255,.06); color:var(--text); cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div style="padding:24px;">

            <div style="margin-bottom:24px;">
                <p style="font-size:12px; color:var(--muted); margin-bottom:8px;">
                    Total Pembayaran
                </p>

                <h2 id="checkoutPrice"
                    style="font-family:'Bebas Neue',sans-serif; font-size:48px; line-height:1; color:var(--red); margin:0;">
                    RP 0
                </h2>
            </div>

            {{-- INFO REKENING --}}
            <div style="background:rgba(255,255,255,.03); border:1px solid var(--border); border-radius:12px; padding:18px; margin-bottom:24px;">

                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <span style="color:var(--muted); font-size:13px;">Bank</span>
                    <strong>BCA</strong>
                </div>

                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <span style="color:var(--muted); font-size:13px;">No. Rekening</span>
                    <strong>123456789</strong>
                </div>

                <div style="display:flex; justify-content:space-between;">
                    <span style="color:var(--muted); font-size:13px;">Atas Nama</span>
                    <strong>UB GYM</strong>
                </div>
            </div>

            <form action="{{ route('member.package.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <input type="hidden" name="type" id="checkoutType">
                <input type="hidden" name="package_id" id="checkoutPackageId">
                <input type="hidden" name="package_name" id="checkoutPackageNameInput">
                <input type="hidden" name="amount" id="checkoutAmount">

                {{-- NAMA --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block; font-size:12px; font-weight:700; margin-bottom:10px;">
                        Nama Pemilik Rekening
                    </label>

                    <input type="text"
                           name="sender_name"
                           required
                           style="width:100%; background:rgba(255,255,255,.04); border:1px solid var(--border); border-radius:10px; padding:14px; color:var(--text);">
                </div>

                {{-- BANK --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block; font-size:12px; font-weight:700; margin-bottom:10px;">
                        Bank Pengirim
                    </label>

                    <select name="sender_bank"
                            required
                            style="width:100%; background:rgba(255,255,255,.04); border:1px solid var(--border); border-radius:10px; padding:14px; color:var(--text);">

                        <option value="">Pilih Bank</option>
                        <option value="BCA">BCA</option>
                        <option value="BRI">BRI</option>
                        <option value="BNI">BNI</option>
                        <option value="MANDIRI">MANDIRI</option>
                        <option value="DANA">DANA</option>
                        <option value="OVO">OVO</option>
                    </select>
                </div>

                {{-- NOMOR --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block; font-size:12px; font-weight:700; margin-bottom:10px;">
                        Nomor Rekening
                    </label>

                    <input type="text"
                           name="sender_account"
                           required
                           style="width:100%; background:rgba(255,255,255,.04); border:1px solid var(--border); border-radius:10px; padding:14px; color:var(--text);">
                </div>

                {{-- BUKTI --}}
                <div style="margin-bottom:24px;">

                    <label style="display:block; font-size:12px; font-weight:700; margin-bottom:10px;">
                        Upload Bukti Pembayaran
                    </label>

                    <input type="file"
                           name="proof_attachment"
                           required
                           accept="image/*"
                           style="width:100%; background:rgba(255,255,255,.04); border:1px solid var(--border); border-radius:10px; padding:14px; color:var(--text);">
                </div>

                <button type="submit"
                        style="width:100%; padding:15px; border:none; border-radius:10px; background:var(--red); color:#fff; font-weight:800; letter-spacing:.08em; cursor:pointer;">
                    KIRIM PEMBAYARAN
                </button>

            </form>

        </div>
    </div>
</div>