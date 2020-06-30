<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Product;
use Illuminate\Support\Facades\DB;

class ShopsController extends Controller
{

    private function productResults() {
        return DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
                            ->select('products.*', 'users.name', 'users.id as userId')
                            ->orderByDesc('updated_at')
                            ->get();
    }

    private function rangeResults($min, $max) {
        return DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
                            ->select('products.*', 'users.name', 'users.id as userId')
                            ->whereBetween('price', [$min, $max])
                            ->orderBy('price')
                            ->get();
    }

    private function lowSort() {
        return DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
                            ->select('products.*', 'users.name', 'users.id as userId')
                            ->orderBy('price')
                            ->get();
    }

    private function highSort() {
        return DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
                            ->select('products.*', 'users.name', 'users.id as userId')
                            ->orderByDesc('price')
                            ->get();
    }

    public function shop(Request $request) 
    {
        $min = $max = $priceSort = '';

        $data = [
            'title' => 'Shop',
            'page' => 'shop',
            'products' => $this->productResults(),
            'category' => 'all',
            'min' => '',
            'max' => '',
            'sortClass' => '',
            'login' => FALSE,
            'register' => FALSE
        ];

        if($request->input('min') && $request->input('max')) {
            $min = $request->input('min');
            $max = $request->input('max');

            $data['min'] = $min;
            $data['max'] = $max;

            $data['products'] = $this->rangeResults($min, $max);
        }

        if($request->input('price_sort')) {
            $priceSort = $request->input('price_sort');

            if($priceSort == 'low') {
                $data['products'] = $this->lowSort();
                $data['sortClass'] = 'low';
            } elseif($priceSort == 'high') {
                $data['products'] = $this->highSort();
                $data['sortClass'] = 'high';
            } else {
                $data['products'] = $this->productResults();
            }
        }

        return view('pages.shop')->with($data);
    }
    
}
