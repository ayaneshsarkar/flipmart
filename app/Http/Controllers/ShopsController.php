<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Product;
use Illuminate\Support\Facades\DB;

class ShopsController extends Controller
{

    private $category = '';

    private function rangeResults($min, $max) {
        return DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
                            ->select('products.*', 'users.name', 'users.id as userId')
                            ->whereBetween('price', [$min, $max])
                            ->orderBy('price')
                            ->get();
    }

    public function shop() 
    {

        //$products = new Product();
        $this->category = 'all';

        $data = [
            'title' => 'Shop',
            'page' => 'shop',
            'category' => $this->category,
            'products' => DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
                                                ->select('products.*', 'users.name', 'users.id as userId')
                                                ->get(),
            'result' => TRUE,
            'login' => FALSE,
            'register' => FALSE
        ];

        return view('pages.shop')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */

    public function getPriceRange(Request $request) {
        $min = $request->input('min');
        $max  =$request->input('max');

        $result = TRUE;

        if(empty($this->rangeResults($min, $max))) {
            $result = FALSE;
        }

        
        $data = [
            'title' => 'Shop',
            'page' => 'shop',
            'category' => $this->category,
            'products' => $this->rangeResults($min, $max),
            'min' => $min,
            'max' => $max,
            'result' => $result,
            'login' => FALSE,
            'register' => FALSE
        ];

        return view('pages.shop')->with($data);
        
    }
}
