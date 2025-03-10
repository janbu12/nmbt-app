<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRentModel extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\ProductFactory::new();
    }

    protected $table = 'products';

    protected $fillable = [
        'name', 'category_id', 'description', 'teaser', 'price', 'stock',
    ];

    // Relations

    public function images()
    {
        return $this->hasMany(ProductImageModel::class, 'product_id');
    }

    public function category(){
        return $this->belongsTo(CategoryModel::class);
    }

    public function rent_details(){
        return $this->hasMany(RentDetailsModel::class, 'product_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'product_id');
    }

    public function cart(){
        return $this->hasMany(Cart::class, 'product_id');
    }

    // Function Rating Start

    public function getAverageRatingAttribute()
    {
        return $this->reviews()
            ->avg('rating') ?: 0;
    }

    public function ratingsDistribution()
    {
        $ratingsCount = $this->reviews()->groupBy('rating')->selectRaw('rating, count(*) as count')->pluck('count', 'rating')->toArray();
        $totalReviews = $this->reviews()->count();

        $ratingsPercentage = [];
        foreach (range(5, 1) as $star) {
            $count = $ratingsCount[$star] ?? 0;
            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
            $ratingsPercentage[$star] = [
                'count' => $count,
                'percentage' => $percentage,
            ];
        }

        return $ratingsPercentage;
    }

    public function formatCountRating($count)
    {
        if ($count >= 1000) {
            return number_format($count / 1000, 1) . ' RB';
        }
        return $count;
    }

    // Function Rating Stop

    // Function Rented Start

    public function getTotalRentedAttribute()
    {
        return $this->rent_details()
            ->whereHas('rent', function ($query) {
                $query->whereIn('status_rent', ['done', 'renting']);
            })
            ->count();
    }

    // Function Rented Stop

    // Function Top Product Start

    public function getTopThreeProductsAttribute()
    {
        // Ambil produk yang memiliki total sewa dan rata-rata rating
        return $this->all()
            ->map(function ($product) {
                // Mengambil jumlah total disewa dari rent_details
                $totalSales = $product->rent_details()
                    ->whereHas('rent', function ($query) {
                        $query->whereIn('status_rent', ['done', 'renting']);
                    })
                    ->sum('quantity');

                // Mengambil rata-rata rating dari reviews
                $averageRating = $product->reviews()->avg('rating') ?: 0;

                return [
                    'product' => $product,
                    'total_sales' => $totalSales,
                    'average_rating' => $averageRating,
                ];
            })
            ->sortByDesc('total_sales') // Urutkan berdasarkan total penjualan
            ->take(3); // Ambil 3 produk teratas
    }

    public function getTopTenProductsAttribute()
    {
        // Ambil produk yang memiliki total sewa dan rata-rata rating
        return $this->all()
            ->map(function ($product) {
                // Mengambil jumlah total disewa dari rent_details
                $totalSales = $product->rent_details()
                    ->whereHas('rent', function ($query) {
                        $query->whereIn('status_rent', ['done', 'renting']);
                    })
                    ->sum('quantity');

                // Mengambil rata-rata rating dari reviews
                $averageRating = $product->reviews()->avg('rating')?: 0;

                return [
                    'product' => $product,
                    'total_sales' => $totalSales,
                    'average_rating' => $averageRating,
                ];
            })
            ->sortByDesc('total_sales')
            ->take(10); // Ambil 10 produk teratas
    }
    // Function Top Product Stop
}
