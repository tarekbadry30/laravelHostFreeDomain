<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


//resend email vertification
    public function resend(Request $request)
    {

        $validateRules=[
            'api_token'   =>  'required',
        ];
        $error= \Illuminate\Support\Facades\Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $user=User::where('api_token',$request->api_token)->get()->first();
        if($user==null){
            return \Response::json(['errors'=>'error login','message'=>'please login and active your account to access']);
        }
        if ($user->hasVerifiedEmail()) {
            return \Response::json(['failed'=>'arredy activated','message'=>'your account is activated before!!!']);

        }
        $user->sendEmailVerificationNotification();
        return \Response::json(['success'=>'email resent','message'=>'email resent check your emails in few seconds']);
    }

    public function register(Request $request)
    {
        $validateRules=[
            'name'          =>  'required|unique:users',
            'email'         =>  'required|unique:users',
            'password'      =>  'required|min:8',

        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $data=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'api_token'=>Str::random(60),
            'password'=>Hash::make($request->password)
        ]);
        $data->sendEmailVerificationNotification();
        $data->message='email created successfully check your email address to active your account';
        return $data;
    }
}
