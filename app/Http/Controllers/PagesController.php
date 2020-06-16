<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
      $data = [
        'title' => 'Welcome To FlipMart',
        'login' => FALSE,
        'register' => FALSE
      ];
      return  view('pages/index')->with($data);
    }
}
