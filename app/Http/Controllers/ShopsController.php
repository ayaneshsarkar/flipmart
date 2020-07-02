<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

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
                            ->paginate(10);
    }

    private function rangeResults($min, $max) {
        return DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
                            ->select('products.*', 'users.name', 'users.id as userId')
                            ->whereBetween('price', [$min, $max])
                            ->orderBy('price')
                            ->paginate(10);
    }

    private function lowSort() {
        return DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
                            ->select('products.*', 'users.name', 'users.id as userId')
                            ->orderBy('price')
                            ->paginate(10);
    }

    private function highSort() {
        return DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
                            ->select('products.*', 'users.name', 'users.id as userId')
                            ->orderByDesc('price')
                            ->paginate(10);
    }

    private function categorySort($category) {
        return DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
        ->select('products.*', 'users.name', 'users.id as userId')
        ->where('category', ucwords($category))
        ->orderByDesc('updated_at')
        ->paginate(10);
    }

    public function shop(Request $request) 
    {
        $min = $max = $priceSort = $category =  '';

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

        if($request->input('category_sort')) {
            $category = $request->input('category_sort');

            if($category == 'women') {
                $data['products'] = $this->categorySort($category);
                $data['category'] = $category;
            } elseif($category == 'men') {
                $data['products'] = $this->categorySort($category);
                $data['category'] = $category;
            } elseif($category == 'kids') {
                $data['products'] = $this->categorySort($category);
                $data['category'] = $category;
            } else {
                $data['products'] = $this->productResults();
                $data['category'] = $category;
            }
        }

        return view('pages.shop')->with($data);
    }

    private function productDetail($slugText) {
        return DB::table('products')->where('product_slug', strtoupper($slugText))->first();
    }

    /**
     * Show the profile for the given user.
     * @param string $slug
     * @return View
    */

    public function product($slug) 
    {
        $data = [
            'title' => 'Product',
            'page' => 'shop',
            'product' => $this->productDetail($slug),
            'login' => FALSE,
            'register' => FALSE
        ];

        return view('pages.product')->with($data);
    }
    
}
