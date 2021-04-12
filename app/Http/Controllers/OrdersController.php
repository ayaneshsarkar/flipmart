<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    public function createCharge($amount)
    {
        $url = env('SHOPIFY_URL') . '/recurring_application_charges.json';

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->post($url, [
            'recurring_application_charge' => [
                'name' => 'Order Charge',
                'price' => $amount,
                'test' => true,
                'return_url' => env('APP_URL') . '/cart'
            ]
        ])->json();

        return $response;
    }
}
