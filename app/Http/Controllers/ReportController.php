<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\RentDetailsModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        // dd($request);
        // Ambil data yang diperlukan
        // $items = RentDetailsModel::with(['product', 'product.images'])->limit(100)->get();
        $rent = Rent::all();

        // Ambil data dari request
        $totalBorrowed = $request->input('total_rents');
        $doneRents = $request->input('done_rents');
        $totalRenting = $request->input('total_renting');
        $ongoingRent = $request->input('ongoing_rents');
        $quantityRentTotal = $request->input('quantity_rented_product');
        $totalIncome = $request->input('income');
        $topTenProducts = json_decode($request->input('topTenProducts'), true);
        $transactions = json_decode($request->input('transactions'), true);
        $rentalLabel = json_decode($request->input('rentalLabel'), true);
        $rentalData = json_decode($request->input('rentalData'), true);
        $incomeLabel = json_decode($request->input('incomeLabel'), true);
        $incomeData = json_decode($request->input('incomeData'), true);

        // Hitung pendapatan berdasarkan hari dan bulan
        $incomeByDay = $this->calculateIncomeByDay($rent);
        $incomeByMonth = $this->calculateIncomeByMonth($rent);
        $rentsByDay = $this->calculateRentsByDay($rent);
        $rentsByMonth = $this->calculateRentsByMonth($rent);

        $viewData = [
            'name' => 'NMBT App',
            'address' => 'Uber Street Gotham City',
            'phone' => '081234567890',
            'email' => 'admin@example.com',
            // 'items' => $items,
            'totalBorrowed' => $totalBorrowed,
            'doneRents' => $doneRents,
            'totalRenting' => $totalRenting,
            'ongoingRent' => $ongoingRent,
            'totalIncome' => $totalIncome,
            'quantityRentTotal' => $quantityRentTotal,
            'incomeByDay' => $incomeByDay,
            'incomeByMonth' => $incomeByMonth,
            'rentsByDay' => $rentsByDay,
            'rentsByMonth' => $rentsByMonth,
            'topTenProducts' => $topTenProducts,
            'transactions' => $transactions,
            'rentalLabel' => $rentalLabel,
            'rentalData' => $rentalData,
            'incomeLabel' => $incomeLabel,
            'incomeData' => $incomeData,
        ];

        // return view('pdf.report', [
        //     'name' => 'NMBT App',
        //     'address' => 'Uber Street Gotham City',
        //     'phone' => '081234567890',
        //     'email' => 'admin@example.com',
        //     'items' => $items,
        //     'totalBorrowed' => $totalBorrowed,
        //     'doneRents' => $doneRents,
        //     'totalRenting' => $totalRenting,
        //     'ongoingRent' => $ongoingRent,
        //     'totalIncome' => $totalIncome,
        //     'quantityRentTotal' => $quantityRentTotal,
        //     'incomeByDay' => $incomeByDay,
        //     'incomeByMonth' => $incomeByMonth,
        //     'rentsByDay' => $rentsByDay,
        //     'rentsByMonth' => $rentsByMonth,
        //     'topTenProducts' => $topTenProducts,
        //     'transactions' => $transactions,
        //     'rentalLabel' => $rentalLabel,
        //     'rentalData' => $rentalData,
        //     'incomeLabel' => $incomeLabel,
        //     'incomeData' => $incomeData,
        // ]);

        // $html = view('pdf.report', $viewData)->render();

        // Browsershot::html($html)
        // ->timeout(60)
        // ->showBackground()
        // ->margins(4, 0, 4, 0)
        // ->format('A4')
        // ->save(storage_path('/app/public/report.pdf'));

        $pdf = Pdf::loadView('pdf.report', $viewData)
        ->setPaper('a4', 'portrait');

        $pdf->save(storage_path('app/public/report.pdf'));

        return response()->download(storage_path('/app/public/report.pdf'));

        // return view('pdf.report', $viewData);
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
