<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class OrdersController extends Controller
{
    public function createOrder(Request $request) 
    {
        $cartItems = DB::table('carts')->select('*')->get();
        $orderSlug = strtoupper(Str::random(12));

        foreach($cartItems as $cartItem) {

            DB::table('orders')->insert([
                'user_id' => session('userId'),
                'product_id' => $cartItem->product_id,
                'order_slug' => $orderSlug,
                'quantity' => $cartItem->quantity,
                'total' => $cartItem->total,
                'status' => 'PENDING'
            ]);

            DB::table('carts')->delete();

        }

        return redirect('/orders')->with(['success' => 'Order Created Successfully!']);
    }
}
