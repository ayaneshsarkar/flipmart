<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Welcome To FlipMart',
            'login' => FALSE,
            'register' => TRUE
        ];
        return  view('pages/index')->with($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signup()
    {
        $data = [
            'title' => 'Welcome To FlipMart',
            'login' => FALSE,
            'register' => TRUE
        ];
        return  view('pages/index')->with($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signin()
    {
        $data = [
            'title' => 'Welcome To FlipMart',
            'login' => TRUE,
            'register' => FALSE
        ];
        return  view('pages/index')->with($data);
    }

    private function randomStrings($strLength) 
    { 
        // String of all alphanumeric character 
        $strResult = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 

        // Shufle the $str_result and returns substring 
        // of specified length 
        return substr(str_shuffle($strResult),  
                        0, $strLength); 
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5|same:confirm_password',
            'confirm_password' => 'required|string|min:5|same:password'
        ]);

        if ($validator->fails()) {
            return redirect('/signup')
            ->withErrors($validator)
            ->withInput();
        }

        $name = $request->input('name');
        $email = $request->input('email');

        // Hash Password
        $password = $request->input('password');
        $hasedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Hashed Verify Key
        $hashVerify = $this->randomStrings(12);

        // Create User
        DB::table('users')->insert(
            [
                'name' => $request->input('name'), 
                'email' => $request->input('email'),
                'password' => $hasedPassword,
                'remember_token' => $hashVerify,
                'verified' => 0
            ]
        );

        $data = [
            'baseURL' => URL::to('/'),
            'hashVerify' => $hashVerify
        ];



        Mail::send('emails.mail', $data, function ($message) use ($email, $name) {
            $message->from('ayaneshsarkar101@gmail.com', 'Ayanesh Sarkar');
            $message->to($email, $name);
            $message->replyTo('ayaneshsarkar101@gmail.com', 'Ayanesh Sarkar');
            $message->subject('Verify');
        });

        if(Mail::failures()) {
            return redirect('/signup')->with(['mailFailure' => 'Sorry, could not send mail.']);
        } 

        return redirect('/signin')->with(['verify' => 'You need to verify before you Sign In.']);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function verify($hashParam) 
    {
        $user = DB::table('users')->where('remember_token', $hashParam)->first();

        if($user == NULL) {
            return redirect('/signup')->with(['signupWarning' => 'Please register to Sign In.']);
        } else {
            $id = $user->id;
            $verifyStatus = $user->verified;

            if($verifyStatus == 0) {
                DB::table('users')->where('id', $id)->update(['verified' => 1]);
                return redirect('/signin')->with(['verifySuccess' => 'Successfully verified, you may now Sign In.']);
            } else {
                return redirect('/signup')->with(['verifyWarnning' => 'Hey, you are already verified!']);
            }
        }
    }

    private function verifyAuth($email, $password) 
    {
        $user = DB::table('users')->where('email', $email)->first();

        if($user != NULL) {
            if(password_verify($password, $user->password)) {
                return $user->id;
            }
        }
    }

    public function login(Request $request) 
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string|min:5'
        ]);

        if ($validator->fails()) {
            return redirect('/signin')
            ->withErrors($validator)
            ->withInput();
        } else {
            $email  = $request->input('email');
            $password = $request->input('password');

            $userId = $this->verifyAuth($email, $password);

            if($userId != NULL) {

                $verifyStatus = DB::table('users')->where('id', $userId)->first();

                if($verifyStatus->verified == 0) {
                    return redirect('/signup')->with(['signupWarning' => 'Please verify before you Sign In.']);
                } else {
                    $sessionData = [
                        'userId' => $userId,
                        'loggedIn' => TRUE,
                        'flash' => 'LoggedIn'
                    ];
    
                    session($sessionData);
    
                    return redirect('/')->with(['signinSuccess' => 'You have successfully logged in.']);
                }

            } else {
                return redirect('/signin')->with(['signinError' => 'Email or Password is wrong.']);
            }
            
        }

    }

    public function logout(Request $request) 
    {
        if(session('loggedIn') == TRUE && $request->input('logout')) {
            session()->forget(['loggedIn', 'userId', 'flash']);
        } else {
            return redirect('/');
        }

        return redirect('/');
    }

    public function authorizeUser()
    {
        if(session('userId')) {
            return true;
        } else {
            return false;
        }
    }

}
