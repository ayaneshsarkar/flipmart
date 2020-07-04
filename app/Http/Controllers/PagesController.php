<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class PagesController extends Controller
{

  private function cartResponse($currentUser) {
    return DB::table('carts')->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $currentUser)
            ->select('carts.quantity', 'carts.price as cartPrice', 'carts.total', 'products.*')
            ->orderByDesc('carts.updated_at')
            ->get();
  }

  public function index() 
  {

    $data = [
      'title' => 'Welcome To FlipMart',
      'page' => 'home',
      'login' => FALSE,
      'register' => FALSE
    ];

    if(session('loggedIn') == TRUE) {
      $data['cartResults'] = $this->cartResponse(session('userId'));
    }


    return  view('pages/index')->with($data);
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
      $data['cartResults'] = $this->cartResponse(session('userId'));
    }

    return  view('pages.about')->with($data);
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
      $data['cartResults'] = $this->cartResponse(session('userId'));
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
