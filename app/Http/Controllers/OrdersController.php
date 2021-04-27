<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use \ConvertApi\ConvertApi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    private function getAwsUrl()
    {
        return 'https://flipmart.s3.us-east-2.amazonaws.com/';
    }

    private function getProduct(int $id)
    {
        $url = env('SHOPIFY_URL') . "/products/$id.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get($url);

        return \json_decode($response, true);
    }

    private function checkoutPostfields($cart)
    {
        $userData = DB::table('users')->where('id', session('userId'))->first();
        $userNameArr = \explode(' ', $userData->name);
        $convertSecret = env('CONVERT_API_SECRET');
        ConvertApi::setApiSecret($convertSecret);

        // Init PostFields
        $postFields = [];

        $postFields['order'] = [
            'billing_address' => [
                "address1" => $userData->address ?? null,
                "address2" => null,
                "city" => $userData->city,
                "company" => null,
                "country" => 'India',
                "first_name" => $userNameArr[0],
                "last_name" => $userNameArr[1],
                "phone" => $userData->phone ?? '7687843512',
                "province" => $userData->state ?? null,
                "zip" => $userData->pincode ? (string)$userData->pincode : null,
                "country_code" => '91'
            ],
            'fulfillment_status' => 'fulfilled',
            'email' => $userData->email,
            'currency' => 'INR',
            'phone' => '7687843512',
            "send_receipt" => true,
            "send_fulfillment_receipt" => true
        ];

        $postFields['order']['shipping_address'] = $postFields['order']['billing_address'];
        $postFields['order']['line_items'] = [];

        // Pushing Line Items
        foreach($cart as $item) {
            $itemData = $this->getProduct($item->shopify_id);
            $itemProduct = $itemData['product'];

            array_push($postFields['order']['line_items'], [
                "id" => (int)$itemProduct['variants'][0]['id'],
                "product_id" => $itemProduct['id'],
                "quantity" => (string)$item->quantity,
                "price" => $itemProduct['variants'][0]['price'],
                "variant_id" => (int)$itemProduct['variants'][0]['id'],
                "vendor" => $itemProduct['vendor']
            ]);
        }

        // echo json_encode($postFields); exit;

        // Creating Order on Shopify
        $url = env('SHOPIFY_URL') . "/orders.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->post($url, $postFields)->json();

        // return $response;

        $orderStatusUrl = $response['order']['order_status_url'];

        $pdf = ConvertApi::convert('pdf', 
            ['Url' => $orderStatusUrl], 'web'
        )   ;

        $pdf = $pdf->getFile()->getContents();
        $pdfName = date('Y-m-d') . Str::random(52) . '.pdf';
        Storage::disk('s3')->put("pdfs/$pdfName", $pdf);

        return $response;
    }

    public function createOrder()
    {
        // Authorization
        if(!session('userId')) return null;

        // Check Empty Cart
        $cart = DB::table('carts')
                ->join('products', 'carts.product_id', 'products.id')
                ->where('carts.user_id', session('userId'))
                ->select(
                    'carts.*', 
                    'carts.id as cartId', 
                    'products.*'
                )
        ->get();

        // Check Empty Cart
        if(empty($cart)) return null;

        return json_encode($this->checkoutPostfields($cart));
    }
}
