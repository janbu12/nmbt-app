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

    public function getAverageRatingAttribute()
    {
        return $this->reviews()
            ->avg('rating') ?: 0;
    }

    public function getTotalRentedAttribute()
    {
        return $this->rent_details()
            ->whereHas('rent', function ($query) {
                $query->whereIn('status_rent', ['done', 'renting']);
            })
            ->count();
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


}
