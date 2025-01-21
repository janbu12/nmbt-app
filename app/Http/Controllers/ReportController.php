<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\RentDetailsModel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        // Ambil data yang diperlukan
        $items = RentDetailsModel::with(['product', 'product.images'])->limit(100)->get();
        $rent = Rent::all();

        // Ambil data dari request
        $totalBorrowed = $request->input('total_rents');
        $doneRents = $request->input('done_rents');
        $totalRenting = $request->input('total_renting');
        $ongoingRent = $request->input('ongoing_rents');
        $quantityRentTotal = $request->input('quantity_rented_product');
        $totalIncome = $request->input('income');

        // Hitung pendapatan berdasarkan hari dan bulan
        $incomeByDay = $this->calculateIncomeByDay($rent);
        $incomeByMonth = $this->calculateIncomeByMonth($rent);

        // Buat view untuk PDF
        $pdf = FacadePdf::loadView('pdf.report', compact(
            'items',
            'totalBorrowed',
            'doneRents',
            'totalRenting',
            'ongoingRent',
            'totalIncome',
            'quantityRentTotal',
            'incomeByDay',
            'incomeByMonth'
        ));

        // Kembalikan PDF sebagai response
        return $pdf->download('report.pdf');
    }

// Fungsi untuk menghitung pendapatan berdasarkan hari
    private function calculateIncomeByDay($rent)
    {
        // Logika untuk menghitung pendapatan berdasarkan hari
        // Misalnya, Anda bisa menggunakan koleksi untuk mengelompokkan dan menjumlahkan pendapatan
        return $rent->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d'); // Mengelompokkan berdasarkan tanggal
        })->map(function($day) {
            return $day->sum('total_price'); // Menghitung total pendapatan per hari
        })->sortKeys();
    }

// Fungsi untuk menghitung pendapatan berdasarkan bulan
    private function calculateIncomeByMonth($rent)
    {
        // Logika untuk menghitung pendapatan berdasarkan bulan
        return $rent->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m'); // Mengelompokkan berdasarkan bulan
        })->map(function($month) {
            return $month->sum('total_price'); // Menghitung total pendapatan per bulan
        })->sortKeys();
    }

}
