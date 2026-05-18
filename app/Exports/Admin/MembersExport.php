<?php

namespace App\Exports\Admin;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MembersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::with([
            'ptMemberships',
            'activeMembership'
        ])
        ->where('role', 'member')
        ->latest()
        ->get()
        ->map(function ($m) {

            $membership = $m->activeMembership;

            $hasPackage = (bool) $membership;

            $packageExpired = $membership
                ? Carbon::parse($membership->end_date)->isPast()
                : false;

            $hasPT = $m->ptMemberships
                ->where('status', 'active')
                ->count();

            return [

                // MEMBER
                'Kode Member' => $m->member_code ?? 'NON MEMBER',

                'Nama Member' => $m->name,

                'WhatsApp' => $m->whatsapp,

                // STATUS MEMBER
                'Status Aktivasi' => $m->is_active_member
                    ? 'Aktivasi'
                    : 'Non-aktivasi',

                // PAKET
                'Paket Gym' => !$hasPackage
                    ? 'Belum Ada Paket'
                    : $membership->package_name,

                'Status Paket' => !$hasPackage
                    ? '-'
                    : ($packageExpired ? 'Expired' : 'Aktif'),

                // BERAKHIR
                'Berakhir Pada' => $membership
                    ? Carbon::parse($membership->end_date)
                        ->format('d M Y')
                    : '-',

                // PT
                'PT Aktif' => $hasPT
                    ? $hasPT . ' Paket'
                    : 'Tidak Ada',

                // CREATED
                'Terdaftar' => $m->created_at
                    ->format('d M Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [

            'Kode Member',
            'Nama Member',
            'WhatsApp',
            'Status Aktivasi',
            'Paket Gym',
            'Status Paket',
            'Berakhir Pada',
            'PT Aktif',
            'Terdaftar',
        ];
    }
}