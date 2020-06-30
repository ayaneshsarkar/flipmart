<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use Illuminate\Support\Facades\DB;

class ShopsController extends Controller
{
    public function shop() 
    {

        //$products = new Product();

        $data = [
            'title' => 'Shop',
            'page' => 'shop',
            'category' => 'all',
            'products' => DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
                                                ->select('products.*', 'users.name', 'users.id as userId')
                                                ->get(),
            'login' => FALSE,
            'register' => FALSE
        ];

        return view('pages.shop')->with($data);
    }
}
