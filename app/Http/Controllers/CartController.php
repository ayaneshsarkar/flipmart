<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function GuzzleHttp\json_encode;

class CartController extends Controller
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

    private function checkCart(int $productId)
    {
        return DB::table('carts')->where('product_id', $productId)->first();
    }

    public function storeCart(Request $request)
    {
        // Authorization
        if(!session('userId')) return null;

        $shopifyId = $request->input('shopify_id') ?? null;
        $size = $request->input('size') ?? null;
        $quantity = $request->input('num-product') ?? null;

        // Check Null Values
        if(!$shopifyId || !$size || !$quantity) return null;

        // Getting Product Id
        $product = DB::table('products')->where('shopify_id', $shopifyId)->first();
        if(empty($product)) return null;
        $productId = $product->id;

        // Getting Shopify Data
        $shopify = $this->getProduct($shopifyId);
        if(!empty($shopify['errors']) || !$shopify) return null;
        $shopifyData = $shopify['product'];

        // Getting the Prices
        $price = $shopifyData['variants'][0]['price'] * $quantity;
        $comparePrice = $shopifyData['variants'][0]['compare_at_price'] * $quantity;

        // Check Cart and Actions according to it
        if(!empty($this->checkCart($productId))) {
            DB::table('carts')->where('product_id', $productId)->update([
                'quantity' => $quantity,
                'size' => $size,
                'total' => $price,
                'compare_total' => $comparePrice
            ]);
        } else {
            DB::table('carts')->insert([
                'user_id' => session('userId'),
                'product_id' => $productId,
                'quantity' => $quantity,
                'size' => $size,
                'total' => $price,
                'compare_total' => $comparePrice
            ]);
        }

        return json_encode([ 
            'status' => TRUE, 
            'title' => $shopifyData['title'],
            'shopifyData' => $shopifyData,
            'productData' => [
                'quantity' => $quantity,
                'price' => $price
            ],
            'cartCount' => DB::table('carts')->where('user_id', session('userId'))->count(),
            'cartTotal' => DB::table('carts')->where('user_id', session('userId'))->sum('total')
        ]);
    }
}
