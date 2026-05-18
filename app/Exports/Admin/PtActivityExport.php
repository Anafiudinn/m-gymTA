<?php

namespace App\Exports\Admin;

use App\Models\PtMembership;
use App\Models\PtSessionLog;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PtActivityExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function query()
    {
        $query = PtSessionLog::with([
            'user',
            'admin'
        ])->latest();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($this->request->filled('search')) {

            $search = $this->request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'member_name',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'coach_name',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas('admin', function ($a) use ($search) {

                        $a->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | DATE FILTER
        |--------------------------------------------------------------------------
        */
        if ($this->request->filled('date_from')) {

            $query->whereDate(
                'created_at',
                '>=',
                $this->request->date_from
            );
        }

        if ($this->request->filled('date_to')) {

            $query->whereDate(
                'created_at',
                '<=',
                $this->request->date_to
            );
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | HEADINGS
    |--------------------------------------------------------------------------
    */
    public function headings(): array
    {
        return [
            'No',
            'Member',
            'Member Code',
            'Coach',
            'Aktivitas',
            'Sesi Sebelum',
            'Sesi Sesudah',
            'Diproses Oleh',
            'Tanggal',
            'Jam',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | MAP DATA
    |--------------------------------------------------------------------------
    */
    public function map($row): array
    {
        static $no = 0;

        $no++;

        return [
            $no,

            $row->member_name,

            $row->user->member_code ?? '-',

            $row->coach_name ?? '-',

            'Potong 1 Sesi',

            $row->previous_session,

            $row->current_session,

            $row->admin->name ?? 'System',

            $row->created_at->format('d M Y'),

            $row->created_at->format('H:i'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STYLING
    |--------------------------------------------------------------------------
    */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')
            ->getFont()
            ->setBold(true);

        return [];
    }
}