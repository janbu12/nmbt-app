<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent
 extends Model
{
    protected $fillable = ['user_id','pickup_date', 'return_date', 'status_rent', 'total_price','payment_method', 'created_at', 'updated_at'];

    public function customer(){
        return $this->belongsTo(User::class);
    }
}
