<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $fillable = ['category_name', 'created_at', 'updated_at'];

    public function products(){
        return $this->hasMany(ProductRentModel::class, 'category_id');
    }

    // Function Top 3 Categories Start
    public function getTopThreeCategoriesAttribute()
    {
        // Ambil kategori yang memiliki total sewa dan rata-rata rating
        return $this->all()
            ->map(function ($category) {
                $totalSales = $category->products()
                ->with(['rent_details as total_rent' => function ($query) {
                    $query->whereHas('rent', function ($query) {
                        $query->whereIn('status_rent', ['done', 'renting']);
                    });
                }])
                ->get()
                ->sum('total_rent');

                return [
                    'category' => $category,
                    'total_sales' => $totalSales,
                ];
            })
            ->sortByDesc('total_sales');
    }
    // Function Top 3 Categories Stop
}
