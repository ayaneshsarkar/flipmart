<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Category;

class ProductController extends Controller
{

    public function admin() {
        $data = [
            'title' => 'Admin',
            'type' => 'admin',
            'orderCount' => 0,
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

        $data['items'] = [];

        $data['count'] = 0;

        $data['total'] = 0;

        return view('admin.orders')->with($data);

    }

    public function addProduct() 
    {
        $category = new Category();

        $data = [
            'title' => 'Add Product',
            'type' => 'addproduct',
            'categories' => $category::orderBy('created_at')->get()
        ];

        return view('admin.addProduct')->with($data);
        
    }


    public function addCategory() {
        $data['title'] = 'Add Brand';
        $data['type'] = 'addcategory';
        return view('admin.addCategory')->with($data);
    }

    public function viewBrands()
    {
        $data = [
            'title' => 'View Brands',
            'type' => 'viewbrands',
            'serial' => 1,
            'brands' => DB::table('categories')->orderBy('created_at')->get()
        ];

        return view('admin.viewbrands')->with($data);
    }

    public function deleteBrand($id)
    {
        $brand = DB::table('categories')->where('id', $id)->first();

        if($brand) {
            DB::table('categories')->where('id', $id)->delete();
        } else {
            return redirect('/admin')->with(['error' => 'No such Brand exist!']);
        }

        return redirect('/admin')->with(['success' => 'Brand deleted successfully!']);
    }

    public function editBrand(Request $request)
    {
        $id = $request->get('id') ?? NULL;
        $brand = DB::table('categories')->where('id', $id)->first();

        if(!$brand) {
            return redirect('/admin')->with(['error' => 'No such Brand exist!']);
        }

        $data = [
            'title' => 'Edit Brand',
            'type' => 'editbrand',
            'brand' => $brand
        ];

        return view('admin.editBrand')->with($data);
    }

    public function updateBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'brand' => 'required|string|max:255'
        ]);

        $id = $request->input('id');

        if($validator->fails()) {
            return redirect("/editbrand/?id=$id")
                    ->withErrors($validator)
                    ->withInput();
        }

        $brand = DB::table('categories')->where('id', $id)->first();

        if(!$brand) return redirect('/admin')->with(['error' => 'No such Brand exist!']);

        DB::table('categories')->where('id', $id)->update([
            'brand' => $request->input('brand')
        ]);

        return redirect('/admin')->with(['success' => 'Brand updated successfully!']);
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
            'brand' => 'nullable|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect('/addcategory')
                    ->withErrors($validator)
                    ->withInput();
        }

        if($request->input('brand') == NULL) {
            return redirect('/admin')->with(['success' => "It's okay, you don't have to add category all the time."]);
        }

        // Create Category
        DB::table('categories')->insert([ 'brand' => $request->input('brand') ]);

        return redirect('/admin')->with(['success' => 'Successfully created category!']);

    }

    private function getAwsUrl()
    {
        return 'https://flipmart.s3.us-east-2.amazonaws.com/';
    }

    private function getDiscount(int $price, int $discount)
    {
        $pointDiscount = $discount / 100;
        return $pointDiscount * $price;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|integer',
            'discount' => 'nullable|integer',
            'delivery_days' => 'required|integer',
            'min_size' => 'required|integer',
            'max_size' => 'required|integer',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'category' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if($validator->fails()) {
            return redirect('/addproduct')
                    ->withErrors($validator)
                    ->withInput();
        }

        $discount = $request->input('discount') ?? 0;

        $postFields = [
            'body_html' => $request->input('description'),
            'handle' => Str::slug($request->input('title')),
            'product_type' => $request->input('category'),
            'status' => 'active',
            'title' => $request->input('title'),
            'vendor' => $request->input('brand'),
            'variants' => [
                [
                    'price' => $this->getDiscount($request->input('price'), $discount),
                    'compare_at_price' => $request->input('price'),
                ]
            ]
        ];

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->post(env('SHOPIFY_URL') . '/products.json', [
            'product' => $postFields
        ])->json();

        if($response['product'] && $response['product']['id']) {
            $productId = $response['product']['id'];
            $awsUrl = "https://flipmart.s3.us-east-2.amazonaws.com/";

            if($request->hasFile('main_image')) {
                $ext = $request->file('main_image')->getClientOriginalExtension();
                $mainImage = Str::random(50) . '.' . $ext;

                $path = $request->file('main_image')->storeAs('mainimages', $mainImage, 's3');
                $awsUrl = $awsUrl . $path;

                Http::withHeaders([
                    'content-type' => 'application/json',
                    'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
                ])
                ->post(env('SHOPIFY_URL') . "/products/$productId/images.json", [
                    'image' => [
                        'position' => 1,
                        'src' => $awsUrl,
                        'filename' => $mainImage
                    ]
                ])->json();
            }

            if($request->hasFile('images')) {
                $i = 0;

                foreach($request->file('images') as $image) {
                    $ext = $image->getClientOriginalExtension();
                    $imageName = Str::random(50) . $i++ . '.' . $ext;

                    $path = $image->storeAs('images', $imageName, 's3');
                    $awsUrl = $this->getAwsUrl() . $path;

                    $fileRes = Http::withHeaders([
                        'content-type' => 'application/json',
                        'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
                    ])
                    ->post(env('SHOPIFY_URL') . "/products/$productId/images.json", [
                        'image' => [
                            'src' => $awsUrl,
                            'filename' => $imageName
                        ]
                    ])->json();
                }
            }

            DB::table('products')->insert([
                'shopify_id' => $productId,
                'delivery_days' => $request->input('delivery_days'),
                'min_size' => $request->input('min_size'),
                'max_size' => $request->input('max_size'),
                'discount' => $request->input('discount') ?? NULL
            ]);
        }

        return redirect('/admin')->with(['success' => 'Product created successfully!']);
    }

}
