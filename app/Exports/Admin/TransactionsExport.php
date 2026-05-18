<?php

namespace App\Exports\Admin;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Invoice',
            'Tanggal',
            'Pelanggan',
            'Kategori',
            'Detail Kategori / Item Retail', // <--- Detail item masuk sini
            'Source',
            'Metode Pembayaran',
            'Admin',
            'Total Jumlah',
            'Status'
        ];
    }

    /**
     * @var \App\Models\Transaction $trx
     */
    public function map($trx): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $trx->invoice_code,
            $trx->created_at->format('d M Y - H:i'),
            $trx->guest_name ?? $trx->user->name ?? '-',
            strtoupper($trx->category),
            $trx->item_details_string, // <--- Hasil string gabungan item / detail paket
            strtoupper($trx->source),
            strtoupper($trx->payment_method),
            $trx->admin->name ?? '-',
            $trx->amount, // Biarkan angka mentah agar excel bisa sum otomatis, kita format di styling nanti
            strtoupper($trx->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Beri style bold untuk header baris ke-1
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);

        // Format kolom J (Total Jumlah) menjadi format Rupiah akuntansi di Excel
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('J2:J' . $highestRow)->getNumberFormat()->setFormatCode('[$Rp-421] #,##0');

        return [];
    }
}
