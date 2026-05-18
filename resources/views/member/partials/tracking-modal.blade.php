{{-- =========================================================
    TRACKING MODAL — Detail Pembayaran
========================================================= --}}
<div id="trackingModal"
    style="position:fixed; inset:0; background:rgba(0,0,0,.82); backdrop-filter:blur(6px); display:none; align-items:center; justify-content:center; z-index:9999; padding:20px;">

    <div style="width:100%; max-width:480px; background:#111114; border:1px solid rgba(255,255,255,.1); border-radius:20px; overflow:hidden; animation:modalPop .2s ease; max-height:90vh; overflow-y:auto;">

        {{-- HEADER --}}
        <div style="padding:20px 24px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid rgba(255,255,255,.07); position:sticky; top:0; background:#111114; z-index:1;">
            <div>
                <p style="font-size:10px; color:#555; text-transform:uppercase; letter-spacing:.14em; margin:0 0 4px;">
                    Detail Pembayaran
                </p>
                <h3 id="trackPackageName" style="font-family:'Barlow Condensed','Barlow',sans-serif; font-weight:900; font-size:22px; color:#fff; letter-spacing:.04em; text-transform:uppercase; margin:0;">
                    -
                </h3>
            </div>

            <button onclick="closeTrackingModal()" type="button"
                style="width:34px; height:34px; border:1px solid rgba(255,255,255,.1); border-radius:10px; background:rgba(255,255,255,.04); color:#666; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div style="padding:22px 24px;">

            {{-- STATUS BANNER --}}
            <div id="statusBanner" style="border-radius:12px; padding:14px 16px; margin-bottom:20px; display:flex; gap:13px; align-items:center;">
                <div id="statusIcon" style="font-size:22px; flex-shrink:0;"></div>
                <div>
                    <div id="statusText" style="font-size:13px; font-weight:800; text-transform:uppercase; letter-spacing:.06em;"></div>
                    <div id="statusSubtext" style="font-size:11px; opacity:.75; margin-top:3px;"></div>
                </div>
            </div>

            {{-- REJECTION REASON --}}
            <div id="rejectionArea" style="display:none; background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.2); border-radius:10px; padding:12px 14px; margin-bottom:18px; font-size:12px; color:#ddd; line-height:1.65;">
                <strong style="color:#ef4444; font-size:11px; text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:4px;">
                    ⚠ Alasan:
                </strong>
                <span id="rejectionReasonText"></span>
            </div>

            {{-- INFO INVOICE --}}
            <div style="background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.07); border-radius:12px; overflow:hidden; margin-bottom:20px;">
                <div style="display:flex; justify-content:space-between; align-items:center; padding:11px 16px; font-size:13px; border-bottom:1px solid rgba(255,255,255,.05);">
                    <span style="color:#555;"># Kode Invoice</span>
                    <span style="display:flex; align-items:center; gap:6px;">
                        <strong id="trackInvoice" style="font-family:monospace; color:#ef4444; font-size:12px;">
                            -
                        </strong>
                        <button onclick="copyInvoice()" type="button" title="Salin kode invoice"
                            style="background:none; border:none; color:#555; cursor:pointer; font-size:13px; padding:2px 4px;">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </span>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; padding:11px 16px; font-size:13px; border-bottom:1px solid rgba(255,255,255,.05);">
                    <span style="color:#555;">Tanggal</span>
                    <span id="trackDate" style="color:#e0e0e0; font-weight:600;">-</span>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; padding:11px 16px; font-size:13px;">
                    <span style="color:#555;">Nominal</span>
                    <strong id="trackAmount" style="color:#ef4444;">-</strong>
                </div>
            </div>

            {{-- DATA PENGIRIM --}}
            <div style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.12em; color:#444; margin-bottom:12px;">
                Data Pengirim
            </div>

            <div style="background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.07); border-radius:12px; overflow:hidden; margin-bottom:20px;">
                <div style="display:flex; justify-content:space-between; align-items:center; padding:11px 16px; font-size:13px; border-bottom:1px solid rgba(255,255,255,.05);">
                    <span style="color:#555;">🏦 Bank</span>
                    <strong id="trackBank" style="color:#e0e0e0;">-</strong>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; padding:11px 16px; font-size:13px; border-bottom:1px solid rgba(255,255,255,.05);">
                    <span style="color:#555;">No. Rekening</span>
                    <strong id="trackAccount" style="color:#e0e0e0; font-family:monospace; font-size:12px;">
                        -
                    </strong>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; padding:11px 16px; font-size:13px; border-bottom:1px solid rgba(255,255,255,.05);">
                    <span style="color:#555;">Atas Nama</span>
                    <strong id="trackSenderName" style="color:#e0e0e0;">-</strong>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; padding:11px 16px; font-size:13px;">
                    <span style="color:#555;">🖼 Bukti</span>
                    <!-- Ubah penampung ini agar bisa diisi element HTML (link / gambar) -->
                    <span id="trackProofContainer" style="max-width:220px; text-align:right;">
                        -
                    </span>
                </div>
            </div>

            {{-- LACAK PROSES --}}
            <div style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.12em; color:#444; margin-bottom:14px;">
                Lacak Proses
            </div>

            <div id="trackTimeline" style="display:flex; flex-direction:column; gap:0;"></div>

            {{-- TIPS --}}
            <div style="margin-top:18px; background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06); border-radius:10px; padding:12px 14px; font-size:12px; color:#555; line-height:1.65;">
                <i class="fa-solid fa-circle-info" style="color:#ef4444; margin-right:5px;"></i>
                <strong style="color:#888;">Tips:</strong>
                simpan / screenshot kode invoice
                <strong id="tipInvoiceCode" style="color:#ef4444;">-</strong>.
                Kalau web error, kamu logout, atau ganti device — tinggal
                kirim kode ini ke admin via WhatsApp untuk cek status pembayaranmu.
            </div>

            {{-- BUTTONS --}}
            <div style="margin-top:20px; display:flex; flex-direction:column; gap:10px;">
                <a id="btnWhatsapp" href="https://wa.me/6281234567890" target="_blank"
                    style="width:100%; padding:13px; border-radius:10px; border:none; background:#ef4444; color:#fff; font-weight:800; font-size:13px; letter-spacing:.07em; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; text-decoration:none;">
                    <i class="fa-brands fa-whatsapp"></i>
                    TANYA ADMIN (WA)
                </a>

                <button id="btnTriggerReupload" type="button"
                    style="display:none; width:100%; padding:12px; border-radius:10px; border:1px solid rgba(239,68,68,.35); background:transparent; color:#ef4444; font-weight:800; font-size:13px; letter-spacing:.07em; cursor:pointer; align-items:center; justify-content:center; gap:8px;">
                    <i class="fa-solid fa-rotate-right"></i>
                    UPLOAD ULANG BUKTI
                </button>
            </div>

        </div>
    </div>
</div>