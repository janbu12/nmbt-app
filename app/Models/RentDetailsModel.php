<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentDetailsModel extends Model
{
    protected $table = 'rent_details';

    protected $fillable = ['product_id','quantity', 'subtotal'];

    public function product(){
        return $this->belongsTo(ProductRentModel::class);
    }

    public function rent(){
        return $this->belongsTo(Rent::class);
    }
}
