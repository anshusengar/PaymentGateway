<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'description', 'image','category_id','sizes'];

    public function category()
{
    return $this->belongsTo(Category::class);
}
public function images()
{
    return $this->hasMany(ProductImage::class);
}

public function reviews()
{
    return $this->hasMany(Review::class);
}

public function getRatingAttribute()
{
    return $this->reviews()->avg('rating');
}

}
