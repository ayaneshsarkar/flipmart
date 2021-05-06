<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use \ConvertApi\ConvertApi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use NumberFormatter;

class OrdersController extends Controller
{
    private function authorizeAdmin()
    {
        $userId = session('userId');
        if(!$userId) return false;

        $user = DB::table('users')->where('id', $userId)->first();
        if(!$user) return false;

        return $user->admin_type !== 'admin' ? false : true;
    }

    private function getOrders()
    {
        $url = env('SHOPIFY_URL') . "/orders.json?status=any";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get($url);

        return $response['orders'] ? $response['orders'] : null;
    }

    private function getUserType(int $userId)
    {
        $user = DB::table('users')->where('id', $userId)->first();

        return !empty($user) ? $user->admin_type : null;
    }

    private function orderIdPerUser(int $userId)
    {
        $shopifyOrderIds = [];
        $orders = DB::table('orders')->where('user_id', $userId)->get();

        foreach($orders as $order) {
            if($order->shopify_order_id) {
                array_push($shopifyOrderIds, $order->shopify_order_id);
            }
        }

        return $shopifyOrderIds;
    }

    private function getOrderCount(int $userId)
    {
        if($this->getUserType($userId) === 'admin') {
            return DB::table('orders')->count();
        } else {
            return DB::table('orders')->where('user_id', $userId)->count();
        }
    }

    private function getOrderTotal(string $userType = 'normal')
    {
        $total = 0;
        $orders = $this->getOrders();
        $shopifyOrderIdsPerUser = $this->orderIdPerUser(session('userId'));

        if($orders) {
            foreach($orders as $order) {
                if($userType === 'admin') {
                    $total += $order['current_subtotal_price'];
                } else {
                    if(\in_array($order['id'], $shopifyOrderIdsPerUser)) {
                        $total += $order['current_subtotal_price'];
                    }
                }
            }
        }

        return $total;
    }

    private function getOrderItems(int $userId)
    {
        $userSpecificOrders = [];

        $userType = $this->getUserType($userId);
        $orders = $this->getOrders();
        $shopifyOrderIdsPerUser = $this->orderIdPerUser($userId);

        if($userType === 'admin') return $orders;

        if($orders) {
            foreach($orders as $order) {
                if(in_array($order['id'], $shopifyOrderIdsPerUser)) {
                    array_push($userSpecificOrders, $order);
                }
            }
        }

        return $userSpecificOrders;
    }

    private function getCartTotal()
    {
        return DB::table('carts')->where('user_id', session('userId'))->sum('total');
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

    private function storeOrderProducts($products, $orderId)
    {
        foreach($products as $item)
        {
            DB::table('order_products')->insert([
                'order_id' => $orderId,
                'shopify_id' => $item->shopify_id,
                'size' => $item->size
            ]);
        }
    }

    private function checkoutPostfields($cart)
    {
        $userData = DB::table('users')->where('id', session('userId'))->first();
        $userNameArr = \explode(' ', $userData->name);

        // Setting Up PDF Converter for Invoicing
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
            "send_fulfillment_receipt" => true,
            'closed_at' => null,
            "taxes_included" => true
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
                "vendor" => $itemProduct['vendor'],
                "taxable" => true
            ]);
        }

        // Creating Order on Shopify
        $url = env('SHOPIFY_URL') . "/orders.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->post($url, $postFields)->json();

        // Getting the Order Status URL for the Invoice
        $orderStatusUrl = $response['order']['order_status_url'];

        // Saving the Invoice
        $pdf = ConvertApi::convert('pdf', 
            ['Url' => $orderStatusUrl], 'web'
        );

        $pdf = $pdf->getFile()->getContents();
        $pdfName = date('Y-m-d') . Str::random(52) . '.pdf';
        Storage::disk('s3')->put("pdfs/$pdfName", $pdf);

        // Storing Order Details Locally
        $orderId = DB::table('orders')->insertGetId([
            'shopify_order_id' => $response['order']['id'],
            'invoice_name' => $pdfName,
            'user_id' => session('userId'),
            'status' => 'open'
        ]);

        // Storing Order Products
        $this->storeOrderProducts($cart, $orderId);

        // Deleting the Cart
        DB::table('carts')->where('user_id', session('userId'))->delete();

        return $response;
    }

    public function createOrder()
    {
        // Authorization
        if(!session('userId')) return json_encode(['error' => 'Not Authorized!']);

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
        if(empty($cart)) return json_encode(['error' => 'Nothing in the Cart!']);

        // Check Cart Total
        if($this->getCartTotal() === 0) return json_encode(['error' => 'Nothing in the Cart!']);

        return json_encode($this->checkoutPostfields($cart));
    }

    public function deleteOrder(int $id)
    {
        // Authorization
        if(!$this->authorizeAdmin()) return redirect('/signin');

        // Getting the Order
        $order = DB::table('orders')->where('shopify_order_id', $id)->first();
        if(!$order) return redirect('/orders');

        // Geting the Invoice Name
        $invoiceName = $order->invoice_name;
        // Delete Url
        $url = env('SHOPIFY_URL') . "/orders/$id.json";

        // Deleting an Order
        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->delete($url);

        if($response->status() === 200) {
            Storage::disk('s3')->delete('/pdfs/' . $invoiceName);
            DB::table('orders')->where('shopify_order_id', $id)->delete();
        }

        return redirect('/orders');
    }

    public function closeOrder(int $id)
    {
        if(!$this->authorizeAdmin()) return redirect('/signin');

        $url = env('SHOPIFY_URL') . "/orders/$id/close.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->post($url);

        if($response['order']) {
            DB::table('orders')->where('shopify_order_id', $id)->update([
                'status' => 'delivered'
            ]);
        }

        return redirect('/orders');
    }

    public function openOrder(int $id)
    {
        if(!$this->authorizeAdmin()) return redirect('/signin');;

        $url = env('SHOPIFY_URL') . "/orders/$id/open.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->post($url);

        if($response['order']) {
            DB::table('orders')->where('shopify_order_id', $id)->update([
                'status' => 'open'
            ]);
        }

        return redirect('/orders');
    }

    public function cancelOrder(int $id)
    {
        if(!session('userId')) return redirect('/signin');

        $url = env('SHOPIFY_URL') . "/orders/$id/cancel.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->post($url);

        if($response['order']) {
            DB::table('orders')->where('shopify_order_id', $id)->update([
                'status' => 'cancelled'
            ]);
        }

        return redirect('/orders');
    }

    public function orders() {
        if(!session('userId')) return redirect('/signin');

        $data = [
            'title' => 'Orders',
            'type' => 'orders',
            'user' => $this->getUserType(session('userId')),
            'items' => $this->getOrderItems(session('userId')),
            'count' => $this->getOrderCount(session('userId')),
            'fmt' => new NumberFormatter('en_IN', NumberFormatter::CURRENCY)
        ];

        // Getting Order Total Per User Type
        if($data['user'] == 'admin') {
            $data['total'] = $this->getOrderTotal('admin');
        } else {
            $data['total'] = $this->getOrderTotal();
        }

        return view('admin.orders')->with($data);
    }

    private function getOrder(int $id)
    {
        $url = env('SHOPIFY_URL') . "/orders/$id.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get($url);

        return json_decode($response, true);
    }

    public function order()
    {
        if(!session('userId')) return redirect('/signin');
        if(!$_GET['id']) return redirect('/orders');

        $order = DB::table('orders')->where('shopify_order_id', $_GET['id'])->first();
        if(!$order) return redirect('/orders');
        
        $orderId = $order->id;
        $orderProducts = [];
        $products = DB::table('order_products')->where('order_id', $orderId)->get();

        foreach($products as $product) {
            $productDetails = $this->getProduct($product->shopify_id);
            $orderProducts[$product->shopify_id] = $productDetails['product'];
        }

        $data = [
            'title' => "Order #" . $_GET['id'],
            'type' => 'singleorder',
            'user' => $this->getUserType(session('userId')),
            'order' => $this->getOrder($_GET['id'])['order'],
            'products' => $products,
            'orderProducts' => $orderProducts,
            'serial' => 1,
            'fmt' => new NumberFormatter('en_IN', NumberFormatter::CURRENCY)
        ];

        return view('admin.order')->with($data);
    }

    public function downloadInvoice(int $id)
    {
        if(!session('userId')) return redirect('/signin');

        $order = DB::table('orders')->where('shopify_order_id', $id)->first();
        if(!$order) return redirect('/orders');

        $invoiceName = $order->invoice_name;
        $invoicePath = "/pdfs/$invoiceName";
        $invoiceUrl = 'https://' . env('AWS_BUCKET') . '.s3.' . 
        env('AWS_DEFAULT_REGION') . '.amazonaws.com' . $invoicePath;

        return redirect($invoiceUrl);
    }
}
