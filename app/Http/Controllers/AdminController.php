<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRentModel as Product;
use App\Models\CategoryModel as Category;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        $monthlyTransactions = Rent::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as total_transactions'))
        ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
        ->orderBy('month', 'asc')
        ->get();

        $monthlyIncome = Rent::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total_price) as totals_income'))
        ->groupBy(DB::raw('month'))
        ->orderBy('month', 'asc')
        ->get();

        $quantityRentTotal = DB::table('rent_details as rd')
            ->join('rents as r', 'rd.rent_id', '=', 'r.id')
            ->whereIn('r.status_rent', ['done', 'renting'])
            ->sum('rd.quantity');

        $transactions = DB::table('categories as c')
            ->select('c.category_name', DB::raw('COUNT(rd.id) as total_transactions'))
            ->join('products as p', 'c.id', '=', 'p.category_id')
            ->join('rent_details as rd', 'p.id', '=', 'rd.product_id')
            ->join('rents as r', 'rd.rent_id', '=', 'r.id')
            ->groupBy('c.category_name')
            ->orderBy('total_transactions', 'DESC')
            ->get();

        $rentedProducts = DB::table('products as p')
            ->select(
                'p.id as product_id',
                'p.name',
                'c.category_name',
                'p.stock',
                DB::raw('SUM(rd.quantity) as total_rented')
            )
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('rent_details as rd', 'p.id', '=', 'rd.product_id')
            ->join('rents as r', 'rd.rent_id', '=', 'r.id')
            ->whereIn('r.status_rent', ['renting'])
            ->groupBy('p.id', 'p.name', 'c.category_name', 'p.stock')
            ->orderBy('total_rented', 'DESC')
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
        return view('admin.dashboard',
            compact(
                'totalRents',
                'totalDoneRents',
                'totalRenting',
                'totalOngoingRents',
                'totalIncome',
                'topTenProducts',
                'quantityRentTotal',
                'months',
                'totals',
                'monthsIncome',
                'totalsIncome',
                'transactions',
                'rentedProducts'
            ));
    }

    public function users() {
        // Ambil data user
        $users = User::with('rent') // Memuat relasi rent
        ->select('id', 'email', 'firstname', 'lastname', 'address', 'birthdate', 'gender') // Sertakan kolom id
        ->paginate(8);

        return view('admin.users', compact('users'));
    }
}
