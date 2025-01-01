<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentDetailsModel extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\RentDetailsFactory::new();
    }

    protected $table = 'rent_details';

    protected $fillable = ['rent_id','product_id','quantity', 'subtotal'];

    public function product(){
        return $this->belongsTo(ProductRentModel::class, 'product_id');
    }

    public function rent(){
        return $this->belongsTo(Rent::class, 'rent_id');
    }
}
