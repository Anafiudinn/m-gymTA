<script>
    /* ============================================================
       1. HELPER SWAL GLOBAL (Tema Dark)
    ============================================================ */
    function _swal(opts) {
        return Swal.fire(Object.assign({
            background: '#0d0d11',
            color: '#f3f3f3',
            confirmButtonColor: '#ff2d2d',
            customClass: {
                popup: 'swal2-popup',
                confirmButton: 'swal2-confirm',
                cancelButton: 'swal2-cancel',
            }
        }, opts));
    }

    /* ============================================================
       2. CHECKOUT MODAL CONTROL
    ============================================================ */
    function openCheckoutModal(name, price, type, packageId = null) {
        document.getElementById('checkoutModal').style.display = 'flex';

        document.getElementById('checkoutPackageName').innerText = name;

        document.getElementById('checkoutPrice').innerText =
            'Rp ' + Number(price).toLocaleString('id-ID');

        document.getElementById('checkoutType').value = type;
        document.getElementById('checkoutPackageId').value = packageId ?? '';
        document.getElementById('checkoutAmount').value = price;
    }

    function closeCheckoutModal() {
        document.getElementById('checkoutModal').style.display = 'none';
    }

    /* ============================================================
       3. INTERCEPT SUBMIT FORM (Checkout & Reupload)
    ============================================================ */
    document.addEventListener('DOMContentLoaded', function () {

        /* --- Intercept Form Checkout --- */
        const checkoutForm = document.querySelector('#checkoutModal form');

        if (checkoutForm) {

            checkoutForm.removeAttribute('onsubmit');

            checkoutForm.addEventListener('submit', function (e) {

                e.preventDefault();

                const btn = checkoutForm.querySelector('[type="submit"]');

                _swal({
                    title: 'KONFIRMASI PEMBAYARAN',
                    html: 'Pastikan data transfer yang kamu masukkan <strong>sudah benar</strong> sebelum dikirim.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-paper-plane"></i>&nbsp;YA, KIRIM',
                    cancelButtonText: 'CEK LAGI',
                    reverseButtons: true,
                    focusCancel: true,
                    allowOutsideClick: false,
                }).then(function (result) {

                    if (result.isConfirmed) {

                        if (btn) {
                            btn.disabled = true;
                            btn.innerHTML =
                                '<i class="fa-solid fa-circle-notch fa-spin"></i>&nbsp;Mengirim...';
                        }

                        _swal({
                            title: 'Mengirim pembayaran...',
                            html: 'Harap tunggu, jangan tutup halaman ini.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: function () {

                                Swal.showLoading();

                                HTMLFormElement.prototype.submit.call(checkoutForm);
                            }
                        });
                    }
                });
            });
        }

        /* --- Intercept Form Reupload --- */
        const reuploadForm = document.getElementById('reuploadForm');

        if (reuploadForm) {

            reuploadForm.removeAttribute('onsubmit');

            reuploadForm.addEventListener('submit', function (e) {

                e.preventDefault();

                const btn = reuploadForm.querySelector('[type="submit"]');

                _swal({
                    title: 'KIRIM ULANG BUKTI?',
                    html: 'Pastikan foto bukti pembayaran yang baru <strong>sudah jelas dan valid</strong>.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-rotate-right"></i>&nbsp;YA, KIRIM ULANG',
                    cancelButtonText: 'BATAL',
                    reverseButtons: true,
                    focusCancel: true,
                    allowOutsideClick: false,
                }).then(function (result) {

                    if (result.isConfirmed) {

                        if (btn) {
                            btn.disabled = true;
                            btn.innerHTML =
                                '<i class="fa-solid fa-circle-notch fa-spin"></i>&nbsp;Mengirim...';
                        }

                        _swal({
                            title: 'Mengirim ulang...',
                            html: 'Harap tunggu.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: function () {

                                Swal.showLoading();

                                HTMLFormElement.prototype.submit.call(reuploadForm);
                            }
                        });
                    }
                });
            });
        }
    });

    /* ============================================================
       4. TRACKING MODAL & AJAX DATA FETCH
    ============================================================ */
    function openTrackingModal(transactionId) {

        document.getElementById('trackingModal').style.display = 'flex';

        fetch(`/member/transaction/${transactionId}`)
            .then(response => response.json())
            .then(data => {

                // =====================================
                // SIMPAN DATA TRANSAKSI GLOBAL
                // =====================================
                window.currentTransaction = data;

                // Mapping Data
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

                document.getElementById('tipInvoiceCode').innerText =
                    data.invoice_code ?? '-';

                /* =====================================
                   Integrasi Chat WhatsApp Admin
                ===================================== */
                const btnWhatsapp = document.getElementById('btnWhatsapp');

                if (btnWhatsapp && data.admin_whatsapp) {

                    const messageText =
                        `Halo Admin, saya ingin menanyakan status pembayaran transaksi dengan Kode Invoice: #${data.invoice_code ?? '-'}`;

                    const encodedMessage =
                        encodeURIComponent(messageText);

                    btnWhatsapp.href =
                        `https://wa.me/${data.admin_whatsapp}?text=${encodedMessage}`;
                }

                /* =====================================
                   Render Bukti Gambar
                ===================================== */
                const proofContainer =
                    document.getElementById('trackProofContainer');

                if (data.proof_attachment) {

                    const fileUrl = data.proof_attachment;

                    proofContainer.innerHTML = `
                        <a href="${fileUrl}" target="_blank" title="Klik untuk memperbesar">
                            <img src="${fileUrl}"
                                 alt="Bukti Pembayaran"
                                 style="max-width:110px;max-height:70px;border-radius:8px;border:1px solid rgba(255,255,255,.12);object-fit:cover;display:block;margin-left:auto;">
                        </a>
                    `;

                } else {

                    proofContainer.innerHTML =
                        '<span style="color:#888;font-size:11px;">-</span>';
                }

                /* =====================================
                   Status Control
                ===================================== */
                const banner         = document.getElementById('statusBanner');
                const icon           = document.getElementById('statusIcon');
                const statusText     = document.getElementById('statusText');
                const statusSubtext  = document.getElementById('statusSubtext');
                const rejectionArea  = document.getElementById('rejectionArea');
                const rejectionText  = document.getElementById('rejectionReasonText');
                const reuploadBtn    = document.getElementById('btnTriggerReupload');

                banner.style.cssText =
                    'border-radius:12px;padding:14px 16px;margin-bottom:20px;display:flex;gap:13px;align-items:center;';

                if (rejectionArea)
                    rejectionArea.style.display = 'none';

                if (reuploadBtn)
                    reuploadBtn.style.display = 'none';

                // =========================
                // STATUS : PENDING
                // =========================
                if (data.status === 'pending') {

                    banner.style.cssText +=
                        'background:rgba(234,179,8,.12);border:1px solid rgba(234,179,8,.2);color:#eab308;';

                    icon.innerHTML =
                        '<i class="fa-regular fa-clock"></i>';

                    statusText.innerText =
                        'MENUNGGU VERIFIKASI';

                    statusSubtext.innerText =
                        'Admin akan verifikasi dalam 1×24 jam';
                }

                // =========================
                // STATUS : SUCCESS
                // =========================
                else if (data.status === 'success') {

                    banner.style.cssText +=
                        'background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.2);color:#10b981;';

                    icon.innerHTML =
                        '<i class="fa-solid fa-circle-check"></i>';

                    statusText.innerText =
                        'PEMBAYARAN BERHASIL';

                    statusSubtext.innerText =
                        'Pembayaran telah diverifikasi dan paket sudah aktif.';
                }

                // =========================
                // STATUS : REJECTED
                // =========================
                else if (data.status === 'rejected') {

                    banner.style.cssText +=
                        'background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.2);color:#ef4444;';

                    icon.innerHTML =
                        '<i class="fa-solid fa-circle-xmark"></i>';

                    statusText.innerText =
                        'PEMBAYARAN DITOLAK';

                    statusSubtext.innerText =
                        data.updated_at ?? '';

                    if (rejectionArea) {

                        rejectionArea.style.display = 'block';

                        rejectionText.innerText =
                            data.rejection_reason ?? 'Tidak ada alasan';
                    }

                    if (reuploadBtn) {

                        reuploadBtn.style.display = 'flex';

                        reuploadBtn.onclick = function () {
                            openReuploadModal(data.id);
                        };
                    }
                }

                // =========================
                // STATUS : CANCELED
                // =========================
                else if (
                    data.status === 'canceled' ||
                    data.status === 'batal'
                ) {

                    banner.style.cssText +=
                        'background:rgba(156,163,175,.12);border:1px solid rgba(156,163,175,.2);color:#9ca3af;';

                    icon.innerHTML =
                        '<i class="fa-solid fa-ban"></i>';

                    statusText.innerText =
                        'TRANSAKSI DIBATALKAN';

                    statusSubtext.innerText =
                        'Transaksi ini telah dibatalkan dan tidak dapat diproses kembali.';
                }

                // Timeline
                buildTimeline(data);
            })
            .catch(err => {
                console.error("Gagal memuat detail tracking:", err);
            });
    }

    function closeTrackingModal() {
        document.getElementById('trackingModal').style.display = 'none';
    }

    /* ============================================================
       ESC KEY AUTO CLOSE
    ============================================================ */
    document.addEventListener('keydown', function(e) {

        if (e.key === 'Escape') {

            const reuploadModal =
                document.getElementById('reuploadModal');

            if (
                reuploadModal &&
                reuploadModal.style.display === 'flex'
            ) {

                closeReuploadModal();

            } else {

                closeTrackingModal();
                closeCheckoutModal();
            }
        }
    });

    /* ============================================================
       5. REUPLOAD MODAL CONTROL
    ============================================================ */
    function closeReuploadModal() {
        document.getElementById('reuploadModal').style.display = 'none';
    }

    function openReuploadModal(id) {

        document.getElementById('trackingModal').style.display = 'none';

        const packageName =
            document.getElementById('trackPackageName').innerText;

        const invoice =
            document.getElementById('trackInvoice').innerText;

        const amount =
            document.getElementById('trackAmount').innerText;

        const reason =
            document.getElementById('rejectionReasonText').innerText;

        // =====================================
        // SHOW MODAL
        // =====================================
        document.getElementById('reuploadModal').style.display = 'flex';

        document.getElementById('reuploadPackageName').innerText =
            packageName;

        document.getElementById('reuploadInvoice').innerText =
            invoice;

        document.getElementById('reuploadAmount').innerText =
            amount;

        document.getElementById('reuploadReason').innerText =
            reason;

        document.getElementById('reuploadForm').action =
            `/member/transaction/${id}/reupload`;

        // =====================================
        // AUTO FILL DATA LAMA
        // =====================================
        if (window.currentTransaction) {

            document.getElementById('reuploadSenderBank').value =
                window.currentTransaction.sender_bank ?? '';

            document.getElementById('reuploadSenderName').value =
                window.currentTransaction.sender_name ?? '';

            document.getElementById('reuploadSenderAccount').value =
                window.currentTransaction.sender_account ?? '';
        }
    }
</script>