<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Category;

class ProductController extends Controller
{

    public function admin() {
        $data = [
            'title' => 'Admin',
            'orderCount' => DB::table('orders')->count(),
            'productCount' => DB::table('products')->count(),
            'categoryCount' => DB::table('categories')->count()
        ];
        return view('admin.dashboard')->with($data);
    }

    public function addProduct() 
    {
        $category = new Category();

        $data = [
            'title'      => 'Add Product',
            'categories' => $category::where('user_id', session('userId'))->orderBy('type', 'desc')->get()
        ];

        return view('admin.addProduct')->with($data);
        
    }


    public function addCategory() {
        $data['title'] = 'Add Category';
        return view('admin.addCategory')->with($data);
    }

    private function randomStrings($strLength) 
    { 
        return substr(md5(time() . session('userId')), 0, $strLength);
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
            return redirect('/admin');
        }

        // Create Category
        DB::table('categories')->insert(
            [
                'user_id'  => session('userId'),
                'type'     => $request->input('type'),
                'brand'    => $request->input('brand')
            ]
        );

        return redirect('/admin');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeProduct(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'min_size'    => 'required|integer',
            'max_size'    => 'required|integer',
            'main_image'  => 'required|image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'images'      => 'required',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif,svg,jiff|max:2048',
            'category'    => 'required|string|max:255',
            'type'        => 'required|string|max:255',
            'brand'       => 'required|string|max:255',
            'description' => 'required|string',
            'info'        => 'nullable|string'
        ]);

        if($validator->fails()) {
            return redirect('/addproduct')
                    ->withErrors($validator)
                    ->withInput();
        }

        $mainImage = '';

        if ($request->hasFile('main_image')) {
            $ext = $request->file('main_image')->getClientOriginalExtension();
            $mainImage = $this->randomStrings(10) . '.' . $ext;

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
                $imageName = $this->randomStrings(10) . time() . $i++ . '.' . $ext;

                $folderName = DB::table('users')->where('id', session('userId'))->first()->name . session('userId');

                $path = \storage_path() . "/app/public/myimages/" . $folderName;

                $image->move($path, $imageName);
                $imagesDB[] = $imageName;
            }
        }

        $info = '';

        (!empty($request->input('info'))) ? $info = $request->input('info') : $info = '';

        DB::table('products')->insert(
            [
                'user_id'      => session('userId'),
                'product_slug' => strtoupper($this->randomStrings(12)),
                'title'        => $request->input('title'),
                'description'  => $request->input('description'),
                'category'     => $request->input('category'),
                'type'         => $request->input('type'),
                'brand'        => $request->input('brand'),
                'main_image'   => $mainImage,
                'images'       => implode(', ', $imagesDB),
                'min_size'     => $request->input('min_size'),
                'max_size'     => $request->input('max_size'),
                'info'         => $info

            ]
        );

        return redirect('/admin');

    }

}