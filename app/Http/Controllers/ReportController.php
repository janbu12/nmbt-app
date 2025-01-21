<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\RentDetailsModel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function generateReport()
       {
           // Ambil data yang diperlukan
           $items = RentDetailsModel::with(['product', 'product.images'])->limit(10)->get();
            $rent = Rent::all();
            $totalBorrowed = $rent->count();
            $totalIncome = $items->sum('subtotal');

            $quantityRentTotal = DB::table('rent_details as rd')
                    ->join('rents as r', 'rd.rent_id', '=', 'r.id')
                    ->whereIn('r.status_rent', ['done', 'renting'])
                    ->sum('rd.quantity');

           // Buat view untuk PDF
           $pdf = FacadePdf::loadView('pdf.report', compact(
                'items',
                'totalBorrowed',
                'totalIncome',
                'quantityRentTotal'
            ));

           // Kembalikan PDF sebagai response
           return $pdf->download('report.pdf');
       }
}
