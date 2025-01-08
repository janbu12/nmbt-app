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

    public function getTotalIncomeAttribute(){
        return $this->sum('total_price');
    }

    public function getTotalAllRentsAttribute()
    {
        return $this->count();
    }

    public function getTotalDoneRentsAttribute()
    {
        return $this->where('status_rent', 'done')->count();
    }

    public function getTotalRentingAttribute()
    {
        return $this->where('status_rent', 'renting')->count();
    }

    public function getTotalOngoingRentsAttribute()
    {
        return $this->whereIn('status_rent', ['process', 'ready_pickup'])->count();
    }

}
