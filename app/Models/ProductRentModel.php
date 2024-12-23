<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRentModel extends Model
{
    protected $fillable = [
        'name', 'category_id', 'description', 'teaser', 'price', 'stock',
    ];

    public function images()
    {
        return $this->hasMany(ProductImageModel::class);
    }

    public function category(){
        return $this->belongsTo(CategoryModel::class);
    }
}
