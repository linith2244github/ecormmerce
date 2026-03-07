<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function Images(){
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function Categories(){
        return $this->hasOne(Category::class,'id', 'category_id');
    }

    public function Brands(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
}
