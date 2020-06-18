<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PagesController extends Controller
{
    public function index() {

      if(session('loggedIn') == TRUE) {
        return redirect('/admin');
      }

      $data = [
        'title' => 'Welcome To FlipMart',
        'login' => FALSE,
        'register' => FALSE
      ];
      return  view('pages/index')->with($data);
    }
}
