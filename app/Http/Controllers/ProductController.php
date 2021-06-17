<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Category;
use NumberFormatter;


class ProductController extends Controller
{
    private function authorizeAdmin()
    {
        $userId = session('userId');
        if(!$userId) return false;

        $user = DB::table('users')->where('id', $userId)->first();
        if(!$user) return false;

        return $user->admin_type !== 'admin' ? false : true;
    }

    private function getProducts()
    {
        $products = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get(env('SHOPIFY_URL') . '/products.json');

        return $products;
    }

    private function getProduct($id)
    {
        $url = env('SHOPIFY_URL') . "/products/$id.json";

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get($url);

        return \json_decode($response, true);
    }

    private function removeLetter(string $word, string $letter)
    {
        $position = \strpos($word, $letter);

        if($position) {
            return \substr($word, 0, $position);
        }

        return NULL;
    }

    public function admin() {
        if(!session('userId')) return redirect('/signin');

        $data = [
            'title' => 'Admin',
            'type' => 'admin',
            'user' => DB::table('users')->where('id', session('userId'))->first(),
            'orderCount' => DB::table('orders')->count(),
            'productCount' => DB::table('products')->where('deleted_at', null)->count(),
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

    public function addProduct() 
    {
        if(!$this->authorizeAdmin()) return redirect('/signin');

        $category = new Category();

        $data = [
            'title' => 'Add Product',
            'type' => 'addproduct',
            'categories' => $category::orderBy('created_at')->get()
        ];

        return view('admin.addProduct')->with($data);
        
    }


    public function addCategory() {
        if(!$this->authorizeAdmin()) return redirect('/signin');

        $data['title'] = 'Add Brand';
        $data['type'] = 'addcategory';
        return view('admin.addCategory')->with($data);
    }

    public function viewBrands()
    {
        if(!$this->authorizeAdmin()) return redirect('/signin');
        
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
        if(!$this->authorizeAdmin()) return redirect('/signin');

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
        if(!$this->authorizeAdmin()) return redirect('/signin');

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
        if(!$this->authorizeAdmin()) return redirect('/signin');
        
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
        if(!$this->authorizeAdmin()) return redirect('/signin');

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
        return $price - ($pointDiscount * $price);
    }

    private function getShopifyDiscount(int $price, int $comparePrice)
    {
        return round(100 - ((100 / $comparePrice) * $price));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function storeProduct(Request $request)
    {
        if(!$this->authorizeAdmin()) return redirect('/signin');

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|integer',
            'discount' => 'nullable|integer',
            'delivery_days' => 'required|integer',
            'min_size' => 'required|integer|lt:max_size',
            'max_size' => 'required|integer|gt:min_size',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'category' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'description' => 'required|string',
            'availability' => 'required|integer',
            'featured' => 'required|integer|digits:1'
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
                    "inventory_quantity" => $request->input('availability')
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
                'discount' => $request->input('discount') ?? NULL,
                'featured' => $request->input('featured')
            ]);
        }

        return redirect('/products')->with(['success' => 'Product created successfully!']);
    }

    public function products()
    {
        if(!$this->authorizeAdmin()) return redirect('/signin');

        $products = $this->getProducts()['products'];

        \usort($products, function ($a, $b) {
            $a = $a['published_at'];
            $b = $b['published_at'];
    
            if ($a == $b) return 0;
            return ($a < $b) ? 1 : -1;
        });

        $availableProducts = [];

        foreach($products as $product) {
            $productId = $product['id'];
            $productDB = DB::table('products')
                            ->where('shopify_id', $productId)->first();
            if(!$productDB->deleted_at) {
                array_push($availableProducts, $product);
            }
        }

        $data = [
            'title' => 'View Products',
            'type' => 'products',
            'serial' => 1,
            'products' => $availableProducts,
            'fmt' => new NumberFormatter('en_IN', NumberFormatter::CURRENCY)
        ];

        return view('admin.products')->with($data);
    }

    public function deleteProduct($id)
    {
        if(!$this->authorizeAdmin()) return redirect('/signin');

        $product = DB::table('products')->where('shopify_id', $id)->first();

        if(empty($product) || $product->deleted_at) {
            return redirect('/products');
        }

        // Mark Product As Deleted
        DB::table('products')->where('shopify_id', $id)->update([
            'deleted_at' => now()
        ]);

        return \redirect('/admin')->with([ 'success' => 'Product Successfully Deleted!' ]);
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

    private function getProductImages(array $images)
    {
        $imagesArr= [];

        foreach($images as $image) {
            if(!empty($image['position']) && $image['position'] !== 1) {
                $imgArr = explode('/', $image['src']);
                $imgString = $this->removeLetter(end($imgArr), '?');

                array_push($imagesArr, $imgString);
            }
        }

        if($imagesArr) return \implode(', ', $imagesArr);

        return NULL;
    }

    public function editProduct(Request $request)
    {
        if(!$this->authorizeAdmin()) return redirect('/signin');

        $id = $request->get('id') ?? NULL;
        $product = $this->getProduct($id);

        if(!empty($product['errors']) || !$id) {
            return \redirect('/admin')->with([ 'error' => 'No such product exists!' ]);
        }

        $data = [
            'title' => 'Edit Product',
            'type' => 'editproduct',
            'categories' => DB::table('categories')->orderBy('created_at')->get(),
            'product' => $product['product'],
            'productImages' => $this->productImages($id)['images'],
            'productData' => $this->productData($id),
            'productImageStrings' => 
            $this->getProductImages($this->productImages($id)['images'])
        ];

        $imageArr = explode('/', $data['product']['image']['src']);
        $imageString = end($imageArr);

        $data['mainImage'] = $this->removeLetter($imageString, '?');

        $data['productDiscount'] = $this->getShopifyDiscount(
            $data['product']['variants'][0]['price'], 
            $data['product']['variants'][0]['compare_at_price']
        );

        return view('admin.editProduct')->with($data);
    }

    private function moveProductImage($image, $productId, $imgId, $many = false)
    {
        if(!$many) {
            $ext = $image->getClientOriginalExtension();
            $mainImage = Str::random(50) . '.' . $ext;

            $path = $image->storeAs('mainimages', $mainImage, 's3');
            $awsUrl = $this->getAwsUrl() . $path;

            // Delete Previous Image
            Http::withHeaders([
                'content-type' => 'application/json',
                'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
            ])->delete(env('SHOPIFY_URL') . "/products/$productId/images/$imgId.json");

            // Move New Image
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

        } else {
            $i = 0;

            foreach($image as $img) {
                $ext = $img->getClientOriginalExtension();
                $imageName = Str::random(50) . $i++ . '.' . $ext;

                $path = $img->storeAs('images', $imageName, 's3');
                $awsUrl = $this->getAwsUrl() . $path;

                Http::withHeaders([
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
    }

    public function updateProduct(Request $request)
    {
        if(!$this->authorizeAdmin()) return redirect('/signin');
        
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'title' => 'required|string|max:255',
            'price' => 'required|integer',
            'discount' => 'nullable|integer',
            'delivery_days' => 'required|integer',
            'min_size' => 'required|integer|lt:max_size',
            'max_size' => 'required|integer|gt:min_size',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'category' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'description' => 'required|string',
            'availability' => 'required|integer',
            'featured' => 'required|integer|digits:1'
        ]);

        if($validator->fails()) {
            return redirect('/editproduct/?id=' . $request->input('id'))
                    ->withErrors($validator)
                    ->withInput();
        }

        $product = $this->getProduct($request->input('id'));

        if(!empty($product['errors'])) {
            return \redirect('/admin')->with([ 'error' => 'Something went wrong!' ]);
        }

        $product = $product['product'];

        $discount = $request->input('discount') ?? 0;

        $putFields = [
            'id' => $request->input('id'),
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
                    "inventory_quantity" => $request->input('availability')
                ]
            ]
        ];

        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->put(env('SHOPIFY_URL') . "/products/".$request->input('id').".json", [
            'product' => $putFields
        ])->json();

        if(!empty($response['product'])) {
            if($request->hasFile('main_image')) {
                $this->moveProductImage(
                    $request->file('main_image'), $product['id'], $product['image']['id']
                );
            }

            if($request->hasFile('images')) {
                $this->moveProductImage(
                    $request->file('images'), $product['id'], null, true
                );
            }

            DB::table('products')->where('shopify_id', $request->input('id'))->update([
                'delivery_days' => $request->input('delivery_days'),
                'min_size' => $request->input('min_size'),
                'max_size' => $request->input('max_size'),
                'discount' => $request->input('discount') ?? NULL,
                'featured' => $request->input('featured')
            ]);

            return \redirect('/products')->with([ 
                'success' => 'Product Successfully Updated!' 
            ]);
        } else {
            return \redirect('/admin')->with([ 'error' => 'Something went wrong!' ]);
        }
    }
}
