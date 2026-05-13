<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithHeadings, WithMapping
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
            'Invoice',
            'Member',
            'Kode Member',
            'Kategori',
            'Detail',
            'Source',
            'Pembayaran',
            'Nominal',
            'Status',
            'Admin',
            'Tanggal',
        ];
    }

    public function map($trx): array
    {
        /*
        |--------------------------------------------------------------------------
        | CATEGORY LABEL
        |--------------------------------------------------------------------------
        */

        $category = match ($trx->category) {
            'activation' => 'Aktivasi Member',
            'monthly' => 'Membership Bulanan',
            'pt' => 'Paket PT',
            'visit' => 'Visit Harian',
            'retail' => 'Penjualan Produk',
            default => ucfirst($trx->category),
        };

        /*
        |--------------------------------------------------------------------------
        | DETAIL
        |--------------------------------------------------------------------------
        */

        $detail = '-';

        // PT
        if ($trx->category === 'pt' && $trx->ptPackage) {

            $detail = $trx->ptPackage->nama_paket;
        }

        // RETAIL
        elseif ($trx->category === 'retail') {

            $items = [];

            if ($trx->transactionItems) {

                foreach ($trx->transactionItems as $item) {

                    $items[] =
                        $item->product->nama_produk .
                        ' x' .
                        $item->qty;
                }
            }

            $detail = implode(', ', $items);
        }

        // ONLINE
        elseif ($trx->source === 'online') {

            $detail =
                ($trx->sender_bank ?? '-') .
                ' - ' .
                ($trx->sender_account ?? '-');
        }

        return [
            $trx->invoice_code,

            $trx->guest_name
                ?? $trx->user->name
                ?? '-',

            $trx->user->member_code
                ?? 'Non Member',

            $category,

            $detail,

            ucfirst($trx->source),

            ucfirst($trx->payment_method),

            $trx->amount,

            ucfirst($trx->status),

            $trx->admin->name
                ?? '-',

            $trx->created_at->format('d M Y H:i'),
        ];
    }
}