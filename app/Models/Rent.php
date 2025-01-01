<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','pickup_date', 'return_date', 'status_rent', 'total_price','payment_method', 'created_at', 'updated_at'];

    public function customer(){
        return $this->belongsTo(User::class);
    }

    public function rent_details()
{
    return $this->hasMany(RentDetailsModel::class);
}

}
