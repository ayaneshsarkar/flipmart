<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthUser extends Model
{
    //Table Name
    protected $table = 'users';
    // Primary Key
    protected $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;
    // Fillable
    protected $fillable = [
        'name', 'email', 'password', 'remember_token', 'verified', 'created_at', 'updated_at'
    ];

}
