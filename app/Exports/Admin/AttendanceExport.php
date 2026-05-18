<?php

namespace App\Exports\Admin;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function query()
    {
        $query = Attendance::with(['user'])->latest();

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($this->request->filled('type')) {
            $query->where('type', $this->request->type);
        }

        return $query;
    }

    public function headings(): array {
        return ['No', 'Nama', 'Member Code', 'WhatsApp', 'Tipe Kehadiran', 'Tanggal', 'Jam'];
    }

    public function map($row): array {
        static $no = 0; $no++;
        return [
            $no,
            $row->guest_name ?? $row->user->name ?? '-',
            $row->user->member_code ?? '-',
            $row->guest_whatsapp ?? $row->user->whatsapp ?? '-',
            $row->type == 'member_package' ? 'Member Bulanan' : 'Visit Harian',
            $row->created_at->format('d M Y'),
            $row->created_at->format('H:i') . ' WIB',
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        return [];
    }
}