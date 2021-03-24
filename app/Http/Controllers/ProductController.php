<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Str;

use App\Category;

use function GuzzleHttp\json_encode;

class ProductController extends Controller
{

    public function admin() {
        $orderCount = DB::table('orders')->join('products', 'orders.product_id', '=', 'products.id')
        ->join('users', 'products.user_id', '=', 'users.id')
        ->select('orders.order_slug')
        ->groupBy('order_slug')
        ->get();

        $data = [
            'title' => 'Admin',
            'type' => 'admin',
            'orderCount' => count($orderCount),
            'productCount' => DB::table('products')->count(),
            'categoryCount' => DB::table('categories')->count()
        ];
        return view('admin.dashboard')->with($data);
    }

    protected function orderItems() {

        return DB::table('orders')->join('products', 'orders.product_id', '=', 'products.id')
        ->where('products.user_id', session('userId'))
        ->join('users', 'products.user_id', '=', 'users.id')
        ->select('orders.quantity as orderQuantity', 'orders.total as orderTotal', 'products.*', 'users.name as name', 'users.id as userId', 'orders.id as orderId', 'orders.status as orderStatus')
        ->orderBy('orders.updated_at')
        ->get();
        
    }

    protected function orderCount() {

        return DB::table('orders')->join('products', 'orders.product_id', '=', 'products.id')
        ->where('products.user_id', session('userId'))
        ->join('users', 'products.user_id', '=', 'users.id')
        ->select('orders.order_slug')
        ->groupBy('order_slug')
        ->get();
        
    }

    protected function orderTotal() {

        return DB::table('orders')->join('products', 'orders.product_id', '=', 'products.id')
        ->where('products.user_id', session('userId'))
        ->join('users', 'products.user_id', '=', 'users.id')
        ->select('orders.total')
        ->sum('orders.total');
        
    }

    public function orders() {

        $data['title'] = 'Orders';
        $data['type'] = 'orders';

        $data['items'] = $this->orderItems();

        $data['count'] = $this->orderCount();

        $data['total'] = $this->orderTotal();

        return view('admin.orders')->with($data);

    }

    public function addProduct() 
    {
        $category = new Category();

        $data = [
            'title' => 'Add Product',
            'type' => 'addproduct',
            'categories' => $category::orderBy('type', 'desc')->get()
        ];

        return view('admin.addProduct')->with($data);
        
    }


    public function addCategory() {
        $data['title'] = 'Add Category';
        $data['type'] = 'addcategory';
        return view('admin.addCategory')->with($data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeCategory(Request $request) 
    {

        $validator = Validator::make($request->all(), [

            'type'     => 'nullable|string|max:255',
            'brand'    => 'nullable|string|max:255'

        ]);

        if($validator->fails()) {
            return redirect('/addcategory')
                    ->withErrors($validator)
                    ->withInput();
        }

        if($request->input('type') == NULL && $request->input('brand') == NULL) {
            return redirect('/admin')->with(['success' => "It's okay, you don't have to add category all the time."]);
        }

        // Create Category
        DB::table('categories')->insert(
            [
                'user_id'  => session('userId'),
                'type'     => $request->input('type'),
                'brand'    => $request->input('brand')
            ]
        );

        return redirect('/admin')->with(['success' => 'Successfully created category.']);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeProductPrevious(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:255',
            'price'         => 'required|integer',
            'discount'      => 'nullable|integer',
            'delivery_days' => 'required|integer',
            'min_size'      => 'required|integer',
            'max_size'      => 'required|integer',
            'main_image'    => 'required|image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'images'        => 'required',
            'images.*'      => 'image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'category'      => 'required|string|max:255',
            'type'          => 'required|string|max:255',
            'brand'         => 'required|string|max:255',
            'description'   => 'required|string',
            'info'          => 'nullable|string'
        ]);

        if($validator->fails()) {
            return redirect('/addproduct')
                    ->withErrors($validator)
                    ->withInput();
        }

        $mainImage = '';

        if ($request->hasFile('main_image')) {
            $ext = $request->file('main_image')->getClientOriginalExtension();
            $mainImage = Str::random(10) . '.' . $ext;

            $folderName = DB::table('users')->where('id', session('userId'))->first()->name . session('userId');

            $path = \storage_path(). "/app/public/myimages/" . $folderName;

            if(!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $request->file('main_image')->move($path, $mainImage);
        }

        $imagesDB = [];

        if($request->file('images')) {
            $i = 0;
            foreach($request->file('images') as $image) {
                $ext = $image->getClientOriginalExtension();
                $imageName = Str::random(10) . time() . $i++ . '.' . $ext;

                $folderName = DB::table('users')->where('id', session('userId'))->first()->name . session('userId');

                $path = \storage_path() . "/app/public/myimages/" . $folderName;

                $image->move($path, $imageName);
                $imagesDB[] = $imageName;
            }
        }

        $info = $discount = '';

        (!empty($request->input('info'))) ? $info = $request->input('info') : $info = '';
        (!empty($request->input('discount'))) ? $discount = $request->input('discount') : $discount = NULL;

        DB::table('products')->insert(
            [
                'user_id'       => session('userId'),
                'product_slug'  => Str::random(12),
                'title'         => $request->input('title'),
                'price'         => $request->input('price'),
                'delivery_days' => $request->input('delivery_days'),
                'discount'      => $discount,
                'description'   => $request->input('description'),
                'category'      => $request->input('category'),
                'type'          => $request->input('type'),
                'brand'         => $request->input('brand'),
                'main_image'    => $mainImage,
                'images'        => implode(', ', $imagesDB),
                'min_size'      => $request->input('min_size'),
                'max_size'      => $request->input('max_size'),
                'info'          => $info

            ]
        );

        return redirect('/admin')->with(['success' => 'Product created successfully']);

    }

    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|integer',
            'discount' => 'nullable|integer',
            'delivery_days' => 'required|integer',
            'min_size' => 'required|integer',
            'max_size' => 'required|integer',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'description' => 'required|string',
            'info' => 'nullable|string'
        ]);

        if($validator->fails()) {
            return redirect('/addproduct')
                    ->withErrors($validator)
                    ->withInput();
        }

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->post(env('SHOPIFY_URL') . '/products.json', [
            'product' => [
                'body_html' => $request->input('description'),
                'handle' => Str::slug($request->input('title')),
                'product_type' => $request->input('type'),
                'status' => 'active',
                'title' => $request->input('title'),
                'vendor' => $request->input('brand'),
                'variants' => [
                    'min_size' => $request->input('min_size'),
                    'max_size' => $request->input('max_size'),
                    'category' => $request->input('category'),
                    'info' => $request->input('info') ?? NULL,
                    'delivery_days' => $request->input('delivery_days'),
                    'discount' => $request->input('discount') ?? NULL,
                    'presentment_prices' => [
                        'price' => [
                            'currency_code' => 'INR',
                            'amount' => $request->input('price')
                        ]
                    ]
                ]
            ]
        ])->json();

        echo json_encode($response);
    }

}
