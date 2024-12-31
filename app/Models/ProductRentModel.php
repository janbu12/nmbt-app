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
}
