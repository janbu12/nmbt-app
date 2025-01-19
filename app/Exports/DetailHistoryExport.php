<?php

namespace App\Exports;

use App\Models\RentDetailsModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DetailHistoryExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RentDetailsModel::select('*')->get();
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->rent_id,
            $row->product_id,
            $row->quantity,
            $row->subtotal,
            $row->created_at,
            $row->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            'ID' ,
            'Rent ID' ,
            'Product ID' ,
            'Quantity' ,
            'Subtotal' ,
            'Created At' ,
            'Updated At' ,
        ];
    }
}
