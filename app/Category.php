<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //Table Name
    protected $table = 'categories';
    // Primary Key
    protected $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;
    // Fillable
    protected $fillable = [
        'user_id', 'gender', 'type', 'brand', 'min_size', 'max_size', 'colors', 'info', 'created_at', 'updated_at'
    ];
}
