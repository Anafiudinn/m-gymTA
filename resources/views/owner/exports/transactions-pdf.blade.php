<!DOCTYPE html>
        }
    </style>
</head>
<body>

    <div class="title">
        Laporan Transaksi Gym
    </div>

    <div class="subtitle">
        Periode:
        {{ $startDate->format('d M Y') }}
        -
        {{ $endDate->format('d M Y') }}
    </div>

    <table>

        <thead>

            <tr>
                <th>Invoice</th>
                <th>Member</th>
                <th>Kategori</th>
                <th>Pembayaran</th>
                <th>Nominal</th>
                <th>Admin</th>
                <th>Tanggal</th>
            </tr>

        </thead>

        <tbody>

            @foreach($transactions as $trx)

                <tr>

                    <td>
                        {{ $trx->invoice_code }}
                    </td>

                    <td>
                        {{ $trx->guest_name ?? $trx->user->name ?? '-' }}
                    </td>

                    <td>
                        {{ ucfirst($trx->category) }}
                    </td>

                    <td>
                        {{ ucfirst($trx->payment_method) }}
                    </td>

                    <td>
                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $trx->admin->name ?? '-' }}
                    </td>

                    <td>
                        {{ $trx->created_at->format('d M Y H:i') }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <div class="total">
        Total Pemasukan:
        Rp {{ number_format($totalIncome, 0, ',', '.') }}
    </div>

</body>
</html>