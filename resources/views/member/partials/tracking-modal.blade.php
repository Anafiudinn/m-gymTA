<div id="trackingModal"
    style="position:fixed;inset:0;background:rgba(0,0,0,.82);backdrop-filter:blur(6px);display:none;align-items:center;justify-content:center;z-index:9999;padding:12px;">

    <div style="width:100%;max-width:420px;background:#111114;border:1px solid rgba(255,255,255,.1);border-radius:14px;overflow:hidden;max-height:calc(100vh - 24px);display:flex;flex-direction:column;">

        {{-- HEADER --}}
        <div style="padding:13px 16px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,.07);flex-shrink:0;">
            <div>
                <p style="font-size:9px;color:#555;text-transform:uppercase;letter-spacing:.14em;margin:0 0 3px;">Detail Pembayaran</p>
                <h3 id="trackPackageName" style="font-family:'Barlow Condensed','Barlow',sans-serif;font-weight:900;font-size:17px;color:#fff;letter-spacing:.04em;text-transform:uppercase;margin:0;">-</h3>
            </div>
            <button onclick="closeTrackingModal()" type="button"
                style="width:30px;height:30px;border:1px solid rgba(255,255,255,.1);border-radius:8px;background:rgba(255,255,255,.04);color:#666;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div style="padding:14px 16px;overflow-y:auto;flex:1;">

            {{-- STATUS BANNER --}}
            <div id="statusBanner" style="border-radius:9px;padding:10px 13px;margin-bottom:14px;display:flex;gap:10px;align-items:center;">
                <div id="statusIcon" style="font-size:18px;flex-shrink:0;"></div>
                <div>
                    <div id="statusText" style="font-size:12px;font-weight:800;text-transform:uppercase;letter-spacing:.06em;"></div>
                    <div id="statusSubtext" style="font-size:10px;opacity:.75;margin-top:2px;"></div>
                </div>
            </div>

            {{-- REJECTION REASON --}}
            <div id="rejectionArea" style="display:none;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:8px;padding:9px 12px;margin-bottom:12px;font-size:11px;color:#ddd;line-height:1.55;">
                <strong style="color:#ef4444;font-size:10px;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:3px;">⚠ Alasan:</strong>
                <span id="rejectionReasonText"></span>
            </div>

            {{-- INFO INVOICE --}}
            <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:9px;overflow:hidden;margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 13px;font-size:12px;border-bottom:1px solid rgba(255,255,255,.05);">
                    <span style="color:#555;"># Kode Invoice</span>
                    <span style="display:flex;align-items:center;gap:5px;">
                        <strong id="trackInvoice" style="font-family:monospace;color:#ef4444;font-size:11px;">-</strong>
                        <button onclick="copyInvoice()" type="button" title="Salin"
                            style="background:none;border:none;color:#555;cursor:pointer;font-size:12px;padding:1px 3px;">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 13px;font-size:12px;border-bottom:1px solid rgba(255,255,255,.05);">
                    <span style="color:#555;">Tanggal</span>
                    <span id="trackDate" style="color:#e0e0e0;font-weight:600;">-</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 13px;font-size:12px;">
                    <span style="color:#555;">Nominal</span>
                    <strong id="trackAmount" style="color:#ef4444;">-</strong>
                </div>
            </div>

            {{-- DATA PENGIRIM --}}
            <div style="font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.12em;color:#444;margin-bottom:8px;">Data Pengirim</div>

            <div style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:9px;overflow:hidden;margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 13px;font-size:12px;border-bottom:1px solid rgba(255,255,255,.05);">
                    <span style="color:#555;">Bank</span>
                    <strong id="trackBank" style="color:#e0e0e0;">-</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 13px;font-size:12px;border-bottom:1px solid rgba(255,255,255,.05);">
                    <span style="color:#555;">No. Rekening</span>
                    <strong id="trackAccount" style="color:#e0e0e0;font-family:monospace;font-size:11px;">-</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 13px;font-size:12px;border-bottom:1px solid rgba(255,255,255,.05);">
                    <span style="color:#555;">Atas Nama</span>
                    <strong id="trackSenderName" style="color:#e0e0e0;">-</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 13px;font-size:12px;">
                    <span style="color:#555;">Bukti</span>
                    <span id="trackProofContainer" style="max-width:180px;text-align:right;">-</span>
                </div>
            </div>

            {{-- LACAK PROSES --}}
            <div style="font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.12em;color:#444;margin-bottom:10px;">Lacak Proses</div>
            <div id="trackTimeline" style="display:flex;flex-direction:column;gap:0;"></div>

            {{-- TIPS --}}
            <div style="margin-top:12px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:8px;padding:9px 12px;font-size:11px;color:#555;line-height:1.55;">
                <i class="fa-solid fa-circle-info" style="color:#ef4444;margin-right:4px;"></i>
                <strong style="color:#888;">Tips:</strong>
                Simpan kode invoice <strong id="tipInvoiceCode" style="color:#ef4444;">-</strong> — kirim ke admin via WhatsApp kalau perlu cek status.
            </div>

          {{-- BUTTONS --}}
            <div style="margin-top:12px;display:flex;flex-direction:column;gap:8px;">
                <a id="btnWhatsapp" href="#" target="_blank"
                    style="width:100%;padding:11px;border-radius:8px;border:none;background:#25d366;color:#fff;font-weight:800;font-size:12px;letter-spacing:.07em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:7px;text-decoration:none;">
                    <i class="fa-brands fa-whatsapp"></i> TANYA ADMIN (WA)
                </a>
                <button id="btnTriggerReupload" type="button"
                    style="display:none;width:100%;padding:10px;border-radius:8px;border:1px solid rgba(239,68,68,.35);background:transparent;color:#ef4444;font-weight:800;font-size:12px;letter-spacing:.07em;cursor:pointer;align-items:center;justify-content:center;gap:7px;">
                    <i class="fa-solid fa-rotate-right"></i> UPLOAD ULANG BUKTI
                </button>
            </div>

        </div>
    </div>
</div>