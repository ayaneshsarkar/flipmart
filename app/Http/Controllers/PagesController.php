<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;

class PagesController extends Controller
{
    private function getFeaturedProducts()
    {
        $availableProducts = [];

        $products = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get(env('SHOPIFY_URL') . '/products.json');

        if($products['products']) {
            $allProducts = $products['products'];

            \usort($allProducts, function ($a, $b) {
                $a = $a['published_at'];
                $b = $b['published_at'];
        
                if ($a == $b) return 0;
                return ($a < $b) ? 1 : -1;
            });

            foreach($allProducts as $product) {
                $productId = $product['id'];

                $productDB = DB::table('products')
                            ->where('shopify_id', $productId)
                ->first();

                if($productDB && !$productDB->deleted_at && $productDB->featured) {
                    array_push($availableProducts, $product);
                }
            }
        }

        return $availableProducts;
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

    private function cartTotal(int $userId)
    {
        return DB::table('carts')->where('user_id', $userId)->sum('total');
    }

    public function index() 
    {

        $data = [
            'title' => 'Welcome To FlipMart',
            'page' => 'home',
            'login' => FALSE,
            'register' => FALSE,
            'featuredProducts' => $this->getFeaturedProducts(),
            'brands' => DB::table('categories')->orderBy('created_at')->get()
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


        return view('pages/index')->with($data);
    }

    public function about() 
    {
        $data = [
            'title' => 'About',
            'page' => 'about',
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

        return view('pages.about')->with($data);
    }

    public function contact() 
    {
        $data = [
            'title' => 'Contact',
            'page' => 'contact',
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

        return  view('pages.contact')->with($data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeMessage(Request $request) 
    {

        $validator = Validator::make($request->all(), [

        'fullname' => 'required|string|max:255',
        'phone_number' => 'required|string|min:10|max:12',
        'email' => 'required|email',
        'message' => 'required|string'

        ]);

        if($validator->fails()) {
        return redirect('/contact')
                ->withErrors($validator)
                ->withInput();
        }

        $fullname = $request->input('fullname');
        $phoneNumber = $request->input('phone_number');
        $email = $request->input('email');
        $message = $request->input('message');

        $data = [
        'fullname' => $fullname,
        'phoneNumber' => $phoneNumber,
        'email' => $email,
        'bodyMessage' => $message
        ];

        Mail::send('emails.contact', $data, function ($message) use ($fullname) {
            $message->from('ayaneshsarkar101@gmail.com', 'Ayanesh Sarkar');
            $message->to('ayaneshsarkar101@gmail.com', 'Ayanesh Sarkar');
            $message->replyTo('ayaneshsarkar101@gmail.com', 'Ayanesh Sarkar');
            $message->subject("Contact Form from $fullname");
        });

        $contactSuccess = 'FALSE';

        if(Mail::failures()) {
        return Redirect::route('/contact')->with(['contactSuccess' => $contactSuccess]);
        }

        DB::table('messages')->insert(

        [
            'fullname' => $fullname,
            'phone_number' => $phoneNumber,
            'email' => $email,
            'message' => $message
        ]

        );

        $contactSuccess = 'TRUE';

        return Redirect::route('contact')->with(['contactSuccess' => $contactSuccess]);

    }

}
