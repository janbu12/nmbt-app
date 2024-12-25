<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRentModel extends Model
{
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
}
