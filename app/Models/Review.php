<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'rating', 'content',
    ];

    public function product(){
        return $this->belongsTo(ProductRentModel::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
