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
        'user_id', 'type', 'brand', 'created_at', 'updated_at'
    ];
}
