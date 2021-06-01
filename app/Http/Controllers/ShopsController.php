<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class ShopsController extends Controller
{
    private function getProduct(int $id)
    {
        $url = env('SHOPIFY_URL') . "/products/$id.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get($url);

        return \json_decode($response, true);
    }

    private function checkCart(int $userId)
    {
        return DB::table('carts')->where('user_id', $userId)->get();
    }

    private function getCart(int $userId)
    {
        // Initialize Shopify Data Array
        $shopifyData = [];

        // Get the Data
        $cartData = DB::table('carts')
                    ->join('products', 'carts.product_id', 'products.id')
                    ->where('carts.user_id', $userId)
                    ->select(
                        'carts.*', 
                        'carts.total as price', 
                        'carts.id as cartId', 
                        'products.*'
                    )
        ->get();

        // Get the Shopify Data
        foreach($cartData as $data) {
            if($data->shopify_id && !empty($this->getProduct($data->shopify_id)['product'])) {
                array_push($shopifyData, $this->getProduct($data->shopify_id)['product']);
            }
        }

        return [
            'cartData' => $cartData,
            'shopifyData' => $shopifyData
        ];
    }

    private function getProducts()
    {
        $availableProducts = [];
        $products = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get(env('SHOPIFY_URL') . '/products.json');

        if($products['products']) {
            foreach($products['products'] as $product) {
                $productId = $product['id'];
                $productDB = DB::table('products')
                            ->where('shopify_id', $productId)->first();
                if($productDB && !$productDB->deleted_at) {
                    array_push($availableProducts, $product);
                }
            }
        }

        return $availableProducts;
    }

    private function productResults() {
        // return DB::table('products')->join('users', 'products.user_id', '=', 'users.id')
        //                     ->select('products.*', 'users.name', 'users.id as userId')
        //                     ->orderBy('updated_at')
        //                     ->paginate(3);

        return DB::table('products')->orderBy('created_at')->get();
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

    private function cartTotal(int $userId)
    {
        return DB::table('carts')->where('user_id', $userId)->sum('total');
    }

    public function shop(Request $request) 
    {
        $min = $max = $priceSort = $category =  '';

        $data = [
            'title' => 'Shop',
            'page' => 'shop',
            'products' => $this->getProducts(),
            'category' => 'all',
            'min' => '',
            'max' => '',
            'sortClass' => '',
            'login' => FALSE,
            'register' => FALSE
        ];

        if(session('loggedIn') == TRUE) {
            if($this->checkCart(session('userId'))) {
                $data['cartResults'] = $this->getCart(session('userId'));
            } else {
                $data['cartResults'] = [];
            }

            $data['cartCount'] = 
            DB::table('carts')->where('user_id', session('userId'))->count() ?? 0;
            $data['cartTotal'] = $this->cartTotal(session('userId')) ?? 0;
        }

        return view('pages.shop')->with($data);
    }

    private function productDetail($id) {
        $url = env('SHOPIFY_URL') . "/products/$id.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get($url);

        return \json_decode($response, true);
    }

    private function productImages($id)
    {
        $url = env('SHOPIFY_URL') . "/products/$id/images.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get($url);

        return \json_decode($response, true);
    }

    private function productData($id)
    {
        return DB::table('products')->where('shopify_id', $id)->first();
    }

    /**
     * Show the profile for the given user.
     * @param string $id
     * @return View
    */

    public function product($id) 
    {
        $product = $this->productDetail($id);

        if(!$product || !$product['product']) {
            return \redirect('/shop');
        }

        $product = $product['product'];

        $productId = $product['id'];
        $productDB = DB::table('products')
                    ->where('shopify_id', $productId)->first();
        if($productDB->deleted_at) {
            return \redirect('/shop');
        }

        $data = [
            'title' => $product['title'],
            'page' => 'shop',
            'product' => $product,
            'productImages' => $this->productImages($id)['images'],
            'productData' => $this->productData($id),
            'random' => Str::random(10),
            'login' => FALSE,
            'register' => FALSE
        ];

        if(session('loggedIn') == TRUE) {
            if($this->checkCart(session('userId'))) {
                $data['cartResults'] = $this->getCart(session('userId'));
            } else {
                $data['cartResults'] = [];
            }

            $data['cartCount'] = 
            DB::table('carts')->where('user_id', session('userId'))->count() ?? 0;
            $data['cartTotal'] = $this->cartTotal(session('userId')) ?? 0;
        }

        return view('pages.product')->with($data);
    }

}
