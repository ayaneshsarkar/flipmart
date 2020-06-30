<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //Table Name
    protected $table = 'products';
    // Primary Key
    protected $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;
    // Fillable
    protected $fillable = [
        'user_id', 'product_slug', 'title', 'price', 'discount', 'description', 'category', 'type', 'brand', 'main_image', 'images', 'min_size', 'max_size', 'info', 'created_at', 'updated_at'
    ];
}
