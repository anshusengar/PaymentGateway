<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{


 


    protected $fillable = [
        'pid',           // Product ID
        'price',
        'description',
        'qty',
        'paymentmethod',
        'userid',
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