<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductRentModel as Product;
use App\Models\CategoryModel as Category;
use App\Models\Rent;

class AdminController extends Controller
{
    public function index(){
        $totalRents = Rent::first()->total_all_rents;
        $totalDoneRents = Rent::first()->total_done_rents;
        $totalRenting = Rent::first()->total_renting;
        $totalOngoingRents = Rent::first()->total_ongoing_rents;
        $totalIncome = Rent::first()->total_income;
        $topTenProducts = Product::first()->top_ten_products;
        $topThreeCategories = Category::first()->top_three_categories;
        return view('admin.dashboard',
            compact(
                'totalRents',
                'totalDoneRents',
                'totalRenting',
                'totalOngoingRents',
                'totalIncome',
                'topTenProducts',
                'topThreeCategories'
            ));
    }
}
