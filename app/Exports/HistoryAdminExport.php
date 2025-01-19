<?php

namespace App\Exports;

use App\Models\Rent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HistoryAdminExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Rent::select('id', 'user_id', 'pickup_date', 'return_date', 'days', 'status_rent', 'total_price', 'payment_method', 'created_at', 'updated_at')
        ->where('status_rent', 'not like', 'unpaid')->get();
    }

    public function map($rent): array
    {
        return [
            $rent->id,
            $rent->user_id,
            $rent->pickup_date,
            $rent->return_date,
            $rent->days,
            $rent->status_rent,
            $rent->total_price,
            $rent->payment_method,
            $rent->created_at,
            $rent->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Total Hari',
            'Status Sewa',
            'Total Harga',
            'Metode Pembayaran',
            'Tanggal Dibuat',
            'Tanggal Diperbarui',
        ];
    }
}
