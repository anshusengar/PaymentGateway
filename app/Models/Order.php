<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{


 


   protected $fillable = [
    'pid',
    'price',
    'description',
    'qty',
    'paymentmethod',
    'userid',
    'status',
    'address',  // street/house
    'phone',
    'pincode',
    'city',
    'state',
    'size',
    'coupon_code',
];
    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'pid');
        // 'pid' is the foreign key in the orders table
    }

   public function user()
{
    return $this->belongsTo(\App\Models\User::class, 'userid');
}


}