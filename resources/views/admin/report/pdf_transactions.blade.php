<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Transaksi</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; padding: 0; color: #1e293b; }
        .header p { margin: 5px 0 0 0; color: #64748b; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px; text-align: left; }
        th { bg-color: #f8fafc; color: #475569; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .badge { padding: 3px 6px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
        .success { background-color: #d1fae5; color: #065f46; }
        .pending { background-color: #fef3c7; color: #92400e; }
        .rejected { background-color: #fee2e2; color: #991b1b; }
        .cancelled { background-color: #e2e8f0; color: #334155; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; background-color: #edf2f7 !important; }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN RIWAYAT TRANSAKSI</h2>
        <p>Dicetak pada: {{ now()->format('d M Y - H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%">No</th>
                <th style="width: 12%">Invoice</th>
                <th style="width: 13%">Tanggal</th>
                <th style="width: 15%">Pelanggan</th>
                <th style="width: 10%">Kategori</th>
                <th style="width: 20%">Detail Paket / Item</th>
                <th style="width: 8%">Source</th>
                <th style="width: 10%">Pembayaran</th>
                <th style="width: 10%" class="text-right">Total</th>
                <th style="width: 9%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse($transactions as $index => $trx)
                @php $grandTotal += $trx->amount; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ $trx->invoice_code }}</td>
                    <td>{{ $trx->created_at->format('d M Y - H:i') }}</td>
                    <td>
                        {{ $trx->guest_name ?? $trx->user->name ?? '-' }}
                        <br><span style="font-size: 9px; color:#94a3b8">Admin: {{ $trx->admin->name ?? '-' }}</span>
                    </td>
                    <td>{{ strtoupper($trx->category) }}</td>
                    <td>
                        @if($trx->category == 'retail')
                            @foreach($trx->items as $item)
                                • {{ $item->product->nama_produk ?? '-' }} ({{ $item->qty }}x)<br>
                            @endforeach
                        @else
                            {{ $trx->detail_label }}
                        @endif
                    </td>
                    <td>{{ strtoupper($trx->source) }}</td>
                    <td>{{ strtoupper($trx->payment_method) }}</td>
                    <td class="text-right" style="font-weight: bold;">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                    <td style="text-align: center;">
                        <span class="badge {{ $trx->status }}">{{ $trx->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 20px;">Tidak ada data transaksi ditemukan.</td>
                </tr>
            @endforelse
            
            @if($transactions->isNotEmpty())
                <tr class="total-row">
                    <td colspan="8" class="text-right">GRAND TOTAL:</td>
                    <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>

</body>
</html>