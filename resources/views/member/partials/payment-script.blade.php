<script>
    /* ============================================================
   CHECKOUT MODAL
============================================================ */
    function openCheckoutModal(name, price, type, packageId = null) {
        document.getElementById('checkoutModal').style.display = 'flex';

        document.getElementById('checkoutPackageName').innerText = name;

        document.getElementById('checkoutPrice').innerText =
            'Rp ' + Number(price).toLocaleString('id-ID');

        document.getElementById('checkoutType').value = type;

        document.getElementById('checkoutPackageId').value =
            packageId ?? '';

        document.getElementById('checkoutAmount').value = price;
    }

    function closeCheckoutModal() {
        document.getElementById('checkoutModal').style.display = 'none';
    }

    /* ============================================================
       TRACKING MODAL
    ============================================================ */
    function closeTrackingModal() {
        document.getElementById('trackingModal').style.display = 'none';
    }

    function copyInvoice() {
        const code = document.getElementById('trackInvoice').innerText;
        if (!code || code === '-') return;
        navigator.clipboard.writeText(code).then(() => {
            const btn = document.querySelector('[onclick="copyInvoice()"]');
            if (btn) {
                btn.innerHTML = '<i class="fa-solid fa-check" style="color:#10b981;"></i>';
                setTimeout(() => {
                    btn.innerHTML = '<i class="fa-regular fa-copy"></i>';
                }, 1500);
            }
        });
    }

    function openTrackingModal(transactionId) {
        document.getElementById('trackingModal').style.display = 'flex';

        fetch(`/member/transaction/${transactionId}`)
            .then(response => response.json())
            .then(data => {

                /* ---- BASIC DATA ---- */
                document.getElementById('trackPackageName').innerText =
                    data.package_name ?? '-';

                document.getElementById('trackInvoice').innerText =
                    data.invoice_code ?? '-';

                document.getElementById('trackDate').innerText =
                    data.created_at ?? '-';

                document.getElementById('trackAmount').innerText =
                    'Rp ' + Number(data.amount).toLocaleString('id-ID');

                document.getElementById('trackBank').innerText =
                    data.sender_bank ?? '-';

                document.getElementById('trackAccount').innerText =
                    data.sender_account ?? '-';
                document.getElementById('trackSenderName').innerText =
                    data.sender_name ?? '-';

                /* ---- PROSES TAMPILKAN BUKTI GAMBAR ---- */
                /* ---- PROSES TAMPILKAN BUKTI GAMBAR ---- */
                const proofContainer = document.getElementById('trackProofContainer');
                if (data.proof_attachment) {
                    // Karena di database sudah berupa URL lengkap, langsung masukkan saja datanya
                    const fileUrl = data.proof_attachment;

                    // Menampilkan gambar kecil (thumbnail) yang bisa diklik untuk memperbesar
                    proofContainer.innerHTML = `
        <a href="${fileUrl}" target="_blank" title="Klik untuk memperbesar">
            <img src="${fileUrl}" alt="Bukti Pembayaran" style="max-width: 110px; max-height: 70px; border-radius: 8px; border: 1px solid rgba(255,255,255,.12); object-fit: cover; display: block; margin-left: auto;">
        </a>
    `;

                } else {
                    proofContainer.innerHTML = '<span style="color:#888; font-size:11px;">-</span>';
                }

                document.getElementById('tipInvoiceCode').innerText =
                    data.invoice_code ?? '-';

                /* ---- ELEMENTS ---- */
                const banner = document.getElementById('statusBanner');
                const icon = document.getElementById('statusIcon');
                const statusText = document.getElementById('statusText');
                const statusSubtext = document.getElementById('statusSubtext');
                const rejectionArea = document.getElementById('rejectionArea');
                const rejectionText = document.getElementById('rejectionReasonText');
                const reuploadBtn = document.getElementById('btnTriggerReupload');

                // reset
                rejectionArea.style.display = 'none';
                reuploadBtn.style.display = 'none';

                /* ---- STATUS: PENDING ---- */
                if (data.status === 'pending') {
                    banner.style.cssText +=
                        'background:rgba(234,179,8,.12);' +
                        'border:1px solid rgba(234,179,8,.2);' +
                        'color:#eab308;';

                    icon.innerHTML = '<i class="fa-regular fa-clock"></i>';
                    statusText.innerText = 'MENUNGGU VERIFIKASI';
                    statusSubtext.innerText = 'Admin akan verifikasi dalam 1×24 jam';
                }

                /* ---- STATUS: SUCCESS ---- */
                else if (data.status === 'success') {
                    banner.style.cssText +=
                        'background:rgba(16,185,129,.12);' +
                        'border:1px solid rgba(16,185,129,.2);' +
                        'color:#10b981;';

                    icon.innerHTML = '<i class="fa-solid fa-circle-check"></i>';
                    statusText.innerText = 'PEMBAYARAN BERHASIL';
                    statusSubtext.innerText = 'Pembayaran telah diverifikasi dan paket sudah aktif.';
                }

                /* ---- STATUS: REJECTED ---- */
                else if (data.status === 'rejected') {
                    banner.style.cssText +=
                        'background:rgba(239,68,68,.12);' +
                        'border:1px solid rgba(239,68,68,.2);' +
                        'color:#ef4444;';

                    icon.innerHTML = '<i class="fa-solid fa-circle-xmark"></i>';
                    statusText.innerText = 'PEMBAYARAN DITOLAK';
                    statusSubtext.innerText = data.updated_at ?? '';

                    rejectionArea.style.display = 'block';
                    rejectionText.innerText = data.rejection_reason ?? 'Tidak ada alasan';

                    reuploadBtn.style.display = 'flex';
                    reuploadBtn.onclick = function() {
                        openReuploadModal(data.id);
                    };
                }

                buildTimeline(data);
            });
    }

    /* ============================================================
       TIMELINE BUILDER
    ============================================================ */
    function buildTimeline(data) {
        const timeline = document.getElementById('trackTimeline');

        const dotBase =
            'width:32px;height:32px;border-radius:50%;' +
            'display:flex;align-items:center;justify-content:center;' +
            'font-size:13px;flex-shrink:0;';

        const dotDone = dotBase + 'background:rgba(16,185,129,.15);color:#10b981;';
        const dotPending = dotBase + 'background:rgba(234,179,8,.12);color:#eab308;';
        const dotRejected = dotBase + 'background:rgba(239,68,68,.12);color:#ef4444;';
        const dotInactive = dotBase + 'background:rgba(255,255,255,.05);color:#444;';

        const lineStyle =
            'width:1px;flex:1;min-height:18px;' +
            'background:rgba(255,255,255,.07);margin:3px 0;';

        const labelActive =
            'font-size:13px;font-weight:700;color:#e0e0e0;line-height:1;margin-bottom:4px;';
        const labelMuted =
            'font-size:13px;font-weight:600;color:#444;line-height:1;margin-bottom:4px;';
        const metaStyle =
            'font-size:11px;color:#555;';

        function tlItem(dotStyle, iconHtml, labelStyle, labelText, metaText, isLast) {
            return `
        <div style="display:flex;gap:14px;">
            <div style="display:flex;flex-direction:column;align-items:center;">
                <div style="${dotStyle}">${iconHtml}</div>
                ${!isLast ? `<div style="${lineStyle}"></div>` : ''}
            </div>
            <div style="padding:4px 0 ${isLast ? '0' : '20px'};flex:1;">
                <div style="${labelStyle}">${labelText}</div>
                ${metaText ? `<div style="${metaStyle}">${metaText}</div>` : ''}
            </div>
        </div>`;
        }

        let html = '';

        /* Step 1: Bukti dikirim — always done */
        html += tlItem(
            dotDone,
            '<i class="fa-solid fa-check"></i>',
            labelActive,
            'Bukti dikirim',
            data.created_at,
            data.status === 'success' ? false : (data.status === 'pending' ? false : false)
        );

        /* Step 2: Verifikasi */
        if (data.status === 'pending') {
            html += tlItem(
                dotPending,
                '<i class="fa-solid fa-spinner fa-spin"></i>',
                labelActive,
                'Sedang diverifikasi admin',
                'Estimasi 1×24 jam',
                false
            );

            /* Step 3: Selesai — inactive */
            html += tlItem(
                dotInactive,
                '<span style="font-size:11px;font-weight:700;color:#444;">3</span>',
                labelMuted,
                'Selesai',
                '',
                true
            );
        } else if (data.status === 'success') {
            html += tlItem(
                dotDone,
                '<i class="fa-solid fa-check"></i>',
                labelActive,
                'Sedang diverifikasi admin',
                data.updated_at ?? '',
                false
            );

            html += tlItem(
                dotDone,
                '<i class="fa-solid fa-check"></i>',
                labelActive,
                'Pembayaran diterima',
                'Paket berhasil diaktifkan',
                true
            );
        } else if (data.status === 'rejected') {
            html += tlItem(
                dotDone,
                '<i class="fa-solid fa-check"></i>',
                labelActive,
                'Sedang diverifikasi admin',
                data.updated_at ?? '',
                false
            );

            html += tlItem(
                dotRejected,
                '<i class="fa-solid fa-xmark"></i>',
                labelActive,
                'Ditolak',
                data.updated_at ?? '',
                true
            );
        }

        timeline.innerHTML = html;
    }

    /* ============================================================
       REUPLOAD MODAL
    ============================================================ */
    function closeReuploadModal() {
        document.getElementById('reuploadModal').style.display = 'none';
    }

    function openReuploadModal(id) {
        document.getElementById('trackingModal').style.display = 'none';

        const packageName = document.getElementById('trackPackageName').innerText;
        const invoice = document.getElementById('trackInvoice').innerText;
        const amount = document.getElementById('trackAmount').innerText;
        const reason = document.getElementById('rejectionReasonText').innerText;

        document.getElementById('reuploadModal').style.display = 'flex';
        document.getElementById('reuploadPackageName').innerText = packageName;
        document.getElementById('reuploadInvoice').innerText = invoice;
        document.getElementById('reuploadAmount').innerText = amount;
        document.getElementById('reuploadReason').innerText = reason;
        document.getElementById('reuploadForm').action =
            `/member/transaction/${id}/reupload`;
    }
</script>