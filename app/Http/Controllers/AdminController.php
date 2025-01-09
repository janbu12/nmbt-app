<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRentModel as Product;
use App\Models\CategoryModel as Category;
use App\Models\Rent;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Product $product){
        $monthlyTransactions = Rent::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as total_transactions'))
        ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
        ->orderBy('month', 'asc')
        ->get();

        $monthlyIncome = Rent::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total_price) as totals_income'))
        ->groupBy(DB::raw('month'))
        ->orderBy('month', 'asc')
        ->get();

        // Siapkan data untuk grafik
        $monthsIncome = $monthlyIncome->pluck('month');
        $totalsIncome = $monthlyIncome->pluck('totals_income');


        // Siapkan data untuk grafik
        $months = $monthlyTransactions->pluck('month');
        $totals = $monthlyTransactions->pluck('total_transactions');

        $totalRents = Rent::first()->total_all_rents;
        $totalDoneRents = Rent::first()->total_done_rents;
        $totalRenting = Rent::first()->total_renting;
        $totalOngoingRents = Rent::first()->total_ongoing_rents;
        $totalIncome = Rent::first()->total_income;
        $topTenProducts = Product::first()->top_ten_products;
        $topThreeCategories = Category::first()->top_three_categories;
        $allProduct= $product->getAllQuantityRented();
        return view('admin.dashboard',
            compact(
                'totalRents',
                'totalDoneRents',
                'totalRenting',
                'totalOngoingRents',
                'totalIncome',
                'topTenProducts',
                'topThreeCategories',
                'allProduct',
                'months',
                'totals',
                'monthsIncome',
                'totalsIncome',
                'monthlyIncome'
            ));
    }
}
