{{-- =========================================================
    REUPLOAD PAYMENT MODAL
========================================================= --}}
<div id="reuploadModal"
     style="position:fixed;
            inset:0;
            background:rgba(0,0,0,.75);
            backdrop-filter:blur(6px);
            display:none;
            align-items:center;
            justify-content:center;
            z-index:10000;
            padding:20px;">

    <div style="width:100%;
                max-width:520px;
                background:var(--bg2);
                border:1px solid var(--border);
                border-radius:18px;
                overflow:hidden;
                animation:modalPop .2s ease;">

        {{-- HEADER --}}
        <div style="padding:22px 24px;
                    border-bottom:1px solid var(--border);
                    display:flex;
                    align-items:center;
                    justify-content:space-between;">

            <div>
                <p style="font-size:11px;
                          color:var(--muted);
                          text-transform:uppercase;
                          letter-spacing:.12em;
                          margin:0 0 4px;">
                    Perbaiki Pembayaran
                </p>

                <h3 id="reuploadPackageName"
                    style="font-size:24px;
                           font-weight:900;
                           margin:0;">
                    Paket
                </h3>
            </div>

            <button onclick="closeReuploadModal()"
                    type="button"
                    style="width:36px;
                           height:36px;
                           border:none;
                           border-radius:10px;
                           background:rgba(255,255,255,.06);
                           color:var(--text);
                           cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        {{-- BODY --}}
        <div style="padding:24px;">

            {{-- TOTAL --}}
            <div style="margin-bottom:24px;">
                <p style="font-size:12px;
                          color:var(--muted);
                          margin-bottom:8px;">
                    Total Pembayaran
                </p>

                <h2 id="reuploadAmount"
                    style="font-family:'Bebas Neue',sans-serif;
                           font-size:48px;
                           line-height:1;
                           color:var(--red);
                           margin:0;">
                    RP 0
                </h2>
            </div>

            {{-- INFO TRANSAKSI --}}
            <div style="background:rgba(255,255,255,.03);
                        border:1px solid var(--border);
                        border-radius:12px;
                        padding:18px;
                        margin-bottom:24px;">

                <div style="display:flex;
                            justify-content:space-between;
                            margin-bottom:10px;">
                    <span style="color:var(--muted);font-size:13px;">
                        Invoice
                    </span>

                    <strong id="reuploadInvoice">
                        INV
                    </strong>
                </div>

                <div style="display:flex;
                            justify-content:space-between;">
                    <span style="color:var(--muted);font-size:13px;">
                        Status
                    </span>

                    <strong style="color:#ef4444;">
                        DITOLAK
                    </strong>
                </div>

            </div>

            {{-- REJECTION REASON --}}
            <div style="background:rgba(239,68,68,.08);
                        border:1px solid rgba(239,68,68,.2);
                        border-radius:12px;
                        padding:16px;
                        margin-bottom:24px;">

                <p style="margin:0 0 8px;
                          font-size:12px;
                          font-weight:800;
                          color:#ef4444;
                          text-transform:uppercase;
                          letter-spacing:.08em;">
                    Alasan Penolakan
                </p>

                <p id="reuploadReason"
                   style="margin:0;
                          color:#ddd;
                          font-size:13px;
                          line-height:1.7;">
                    -
                </p>

            </div>

            {{-- FORM --}}
            <form id="reuploadForm"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- BANK --}}
                <div style="margin-bottom:18px;">

                    <label style="display:block;
                                  font-size:12px;
                                  font-weight:700;
                                  margin-bottom:10px;">
                        Bank Pengirim
                    </label>

                    <select name="sender_bank"
                            required
                            style="width:100%;
                                   background:rgba(255,255,255,.04);
                                   border:1px solid var(--border);
                                   border-radius:10px;
                                   padding:14px;
                                   color:var(--text);">

                        <option value="">Pilih Bank</option>
                        <option value="BCA">BCA</option>
                        <option value="BRI">BRI</option>
                        <option value="BNI">BNI</option>
                        <option value="MANDIRI">MANDIRI</option>
                        <option value="SEA BANK">SEA BANK</option>
                        <option value="DANA">DANA</option>
                        <option value="OVO">OVO</option>

                    </select>

                </div>

                {{-- NAMA REKENING --}}
                <div style="margin-bottom:18px;">

                    <label style="display:block;
                                  font-size:12px;
                                  font-weight:700;
                                  margin-bottom:10px;">
                        Nama Pengirim
                    </label>

                    <input type="text"
                           name="sender_name"
                           required
                           placeholder="Nama pemilik rekening"
                           style="width:100%;
                                  background:rgba(255,255,255,.04);
                                  border:1px solid var(--border);
                                  border-radius:10px;
                                  padding:14px;
                                  color:var(--text);">

                </div>

                {{-- NOMOR REKENING --}}
                <div style="margin-bottom:18px;">

                    <label style="display:block;
                                  font-size:12px;
                                  font-weight:700;
                                  margin-bottom:10px;">
                        Nomor Rekening / E-Wallet
                    </label>

                    <input type="text"
                           name="sender_account"
                           required
                           placeholder="0812xxxx / 123456"
                           style="width:100%;
                                  background:rgba(255,255,255,.04);
                                  border:1px solid var(--border);
                                  border-radius:10px;
                                  padding:14px;
                                  color:var(--text);">

                </div>

                {{-- UPLOAD --}}
                <div style="margin-bottom:24px;">

                    <label style="display:block;
                                  font-size:12px;
                                  font-weight:700;
                                  margin-bottom:10px;">
                        Upload Bukti Baru
                    </label>

                    <input type="file"
                           name="proof_attachment"
                           required
                           accept="image/*"
                           style="width:100%;
                                  background:rgba(255,255,255,.04);
                                  border:1px solid var(--border);
                                  border-radius:10px;
                                  padding:14px;
                                  color:var(--text);">

                </div>

                {{-- BUTTON --}}
                <button type="submit"
                        style="width:100%;
                               padding:15px;
                               border:none;
                               border-radius:10px;
                               background:var(--red);
                               color:#fff;
                               font-weight:800;
                               letter-spacing:.08em;
                               cursor:pointer;
                               margin-bottom:14px;">
                    KIRIM ULANG PEMBAYARAN
                </button>

                {{-- CHAT ADMIN --}}
                <a href="https://wa.me/6281234567890"
                   target="_blank"
                   style="width:100%;
                          display:flex;
                          align-items:center;
                          justify-content:center;
                          gap:10px;
                          padding:14px;
                          border-radius:10px;
                          border:1px solid rgba(255,255,255,.08);
                          background:rgba(255,255,255,.03);
                          color:var(--text);
                          text-decoration:none;
                          font-weight:700;">

                    <i class="fa-brands fa-whatsapp"></i>
                    Chat Admin

                </a>

            </form>

        </div>
    </div>
</div>