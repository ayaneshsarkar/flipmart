<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use Illuminate\Http\Request;

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


    public function addCategory() {
        $data['title'] = 'Add Category';
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

            'gender'   => 'required|string|max:255',
            'type'     => 'required|string|max:255',
            'brand'    => 'required|string|max:255',
            'min_size' => 'required|integer',
            'max_size' => 'required|integer',
            'colors'   => 'required|string|max:255',
            'info'     => 'string|nullable'

        ]);

        if($validator->fails()) {
            return redirect('/addcategory')
                    ->withErrors($validator)
                    ->withInput();
        }

        (!empty($request->input('info'))) ? $info = $request->input('info') : $info  = '';

        // Create Category
        DB::table('categories')->insert(
            [
                'user_id'  => session('userId'),
                'gender'   => $request->input('gender'),
                'type'     => $request->input('type'),
                'brand'    => $request->input('brand'),
                'min_size' => $request->input('min_size'),
                'max_size' => $request->input('max_size'),
                'colors'   => strtolower($request->input('colors')),
                'info'    => $info
            ]
        );

        return redirect('/admin');

    }
}
