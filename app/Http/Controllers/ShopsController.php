<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

use function GuzzleHttp\json_decode;

class ShopsController extends Controller
{
    private function getProducts()
    {
        $products = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get(env('SHOPIFY_URL') . '/products.json');

        return $products;
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

    private function cartResponse($currentUser) {
        return DB::table('carts')->join('products', 'carts.product_id', '=', 'products.id')
                ->where('carts.user_id', $currentUser)
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('carts.quantity', 'carts.price as cartPrice', 'carts.total', 'products.*', 'users.name as name', 'users.id as userId', 'carts.id as cartId')
                ->orderByDesc('carts.updated_at')
                ->get();
    }

    private function cartTotal() {
        return DB::table('carts')->where('user_id', session('userId'))->sum('total');
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
            // if($this->cartResponse(session('userId')) != NULL) {
            //     $data['cartResults'] = $this->cartResponse(session('userId'));
            //     $data['cartTotal'] = $this->cartTotal();
            // } else {
            //     $data['cartResults'] = '';
            // }

            $data['cartResults'] = '';
        }

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
            $data['page'] = 'category';

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
        $data = [
            'title' => 'Product',
            'page' => 'shop',
            'product' => $this->productDetail($id)['product'],
            'productImages' => $this->productImages($id)['images'],
            'productData' => $this->productData($id),
            'random' => Str::random(10),
            'login' => FALSE,
            'register' => FALSE
        ];

        // if(session('loggedIn') == TRUE) {
        //     if(count($this->cartResponse(session('userId'))) !== 0) {
        //         $data['cartResults'] = $this->cartResponse(session('userId'));
        //         $data['cartTotal'] = $this->cartTotal();
        //     }
        // }

        return view('pages.product')->with($data);
    }

    private function productResponse($currentUser) {
        return DB::table('carts')->join('products', 'carts.product_id', '=', 'products.id')
                ->where('carts.user_id', $currentUser)
                ->join('users', 'products.user_id', '=', 'users.id')
                ->select('carts.quantity', 'carts.price as cartPrice', 'carts.total', 'products.*', 'users.name as name', 'users.id as userId', 'carts.id as cartId')
                ->orderBy('carts.updated_at')
                ->get();
    }

    public function storeCart(Request $request) {

        $productSlug =  $request->input('productSlug');

        $productId = DB::table('products')->where('product_slug', $productSlug)->first()->id;
        $productExists = DB::table('carts')->where('product_id', $productId)->where('user_id', session('userId'))
        ->get();

        $price = DB::table('products')->where('product_slug', $productSlug)->first()->price;
        $size = DB::table('products')->where('product_slug', $productSlug)->first()->max_size;

        $currentUser = session('userId');

        if(count($productExists) == 0) {

            DB::table('carts')->insert([
                'user_id' => session('userId'),
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $price,
                'total' => 1 * $price,
                'size' => $size
            ]);

        } else {

            $quantity = DB::table('carts')->where('product_id', $productId)->where('user_id', session('userId'))
            ->first();

            DB::table('carts')->where('product_id', $productId)->where('user_id', session('userId'))->update([
                'quantity' => $quantity->quantity + 1,
                'total' => ($quantity->quantity + 1) * $price
            ]);
        }

        $data = [
            'product' => $this->productResponse($currentUser),
            'url' => URL::to('/'),
            'total' => $this->cartTotal()
        ];

        return response()->json($data, 200);
        
    }

    public function deleteCart(Request $request) {

        $cartId = $request->input('cartId');

        DB::table('carts')->where('id', $cartId)->delete();
        
        $total = DB::table('carts')->sum('total');

        $count = DB::table('carts')->count();

        return response()->json(['status' => 'Deleted!', 'total' => $total, 'count' => $count]);

    }

    public function updateCart(Request $request) {

        $quantity = $request->input('quantity');
        $cartId = $request->input('cartId');
        $price = DB::table('carts')->where('id', $cartId)->first()->price;

        $updateCartData = [
            'quantity' => $quantity,
            'total' => $quantity * $price
        ];

        DB::table('carts')->where('id', $cartId)->update($updateCartData);

        $singletotal = DB::table('carts')->where('id', $cartId)->first()->total;
        $total = DB::table('carts')->sum('total');

        return response()->json(['singleTotal' => $singletotal, 'total' => $total]);

    }

    public function storeSingleCart(Request $request) {

        $productSlug = $request->input('productSlug');
        $productQuantity = $request->input('productQuantity');
        $productSize = $request->input('productSize');

        $productId = DB::table('products')->where('product_slug', $productSlug)->first()->id;
        $productPrice = DB::table('products')->where('product_slug', $productSlug)->first()->price;
        
        if($productSize == 'null') {
            $productSize = DB::table('products')->where('product_slug', $productSlug)->first()->max_size;
        }

        $productExists = DB::table('carts')->where('product_id', $productId)->where('user_id', session('userId'))
        ->get();

        if(count($productExists) == 0) {

            $insertData = [
                'user_id' => session('userId'),
                'product_id' => $productId,
                'quantity' => $productQuantity,
                'price' => $productPrice,
                'total' => $productQuantity * $productPrice,
                'size' => $productSize
            ];

            DB::table('carts')->insert($insertData);

        } else {

            $cartQuantity = DB::table('carts')->where('product_id', $productId)->where('user_id', session('userId'))
            ->first()->quantity;

            $updateData = [
                'quantity' => $cartQuantity + $productQuantity,
                'total' => ($cartQuantity + $productQuantity) * $productPrice,
                'size' => $productSize
            ];

            DB::table('carts')->where('product_id', $productId)->where('user_id', session('userId'))
            ->update($updateData);

        }


        return response()->json(['url' => URL::to('/shop')]);

    }
}
