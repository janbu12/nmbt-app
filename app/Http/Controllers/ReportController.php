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
        // dd($request);
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
        $rentsByDay = $this->calculateRentsByDay($rent);
        $rentsByMonth = $this->calculateRentsByMonth($rent);

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
            'incomeByMonth',
            'rentsByDay',
            'rentsByMonth',
        ));

        // Kembalikan PDF sebagai response
        return $pdf->download('report.pdf');
    }

// Fungsi untuk menghitung pendapatan berdasarkan hari
    private function calculateIncomeByDay($rent)
    {
        return $rent->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function($day) {
            return $day->sum('total_price');
        })->sortKeys()->map(function($income, $key) {
            return [
                'income' => $income,
                'formatted_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $key)->format('d F Y')
            ];
        });
    }

    private function calculateIncomeByMonth($rent)
    {
        return $rent->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m');
        })->map(function($month) {
            return $month->sum('total_price');
        })->sortKeys()->map(function($income, $key) {
            return [
                'income' => $income,
                'formatted_date' => \Carbon\Carbon::createFromFormat('Y-m', $key)->format('F Y')
            ];
        });
    }

    private function calculateRentsByDay($rent)
    {
        return $rent->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
        })->map(function($day) {
            return $day->count();
        })->sortKeys()->map(function($rents, $key) {
            return [
                'rents' => $rents,
                'formatted_date' => \Carbon\Carbon::createFromFormat('Y-m-d', $key)->format('d F Y')
            ];
        });
    }

    private function calculateRentsByMonth($rent)
    {
        return $rent->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('Y-m');
        })->map(function($month) {
            return $month->count();
        })->sortKeys()->map(function($rents, $key) {
            return [
                'rents' => $rents,
                'formatted_date' => \Carbon\Carbon::createFromFormat('Y-m', $key)->format('F Y')
            ];
        });
    }

}
