<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validateRules=[
            'email'         =>  'required',
            'password'      =>  'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $credentials  = array('email' => $request->email, 'password' => $request->password);
        if (Auth::attempt($credentials, $request->has('remember'))){
            $user=User::where('email',$request->email)->get()->first();
            $user->api_token= Str::random(60);
            $user->save();
            $user=User::where('email',$request->email)->get()->first();
            if($user->email_verified_at ==''){
                return \Response::json(['failed'=>'login failed you need to active your acount ','userData'=>$user]);

            }
            return \Response::json(['success'=>'login success ','userData'=>$user]);
        }
        return \Response::json(['error'=>'login failed ','message'=>'incorrect username or password']);



    }
    public function APIgoogleLogin(Request $request)
    {
        $validateRules=[
            'email'         =>  'required',
            'name'          =>  'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }


        // check if they're an existing user
        $existingUser = User::where('email', $request->email)->first();
        if($existingUser){
            // log them in
            $user=User::where('email',$request->email)->get()->first();
            $user->api_token= Str::random(60);
            if( $user->email_verified_at ==null){
                $user->email_verified_at = now();
            }
            $user->save();
            $user=User::where('email',$request->email)->get()->first();

            return \Response::json(['success'=>'login success ','userData'=>$user]);
        } else {
            // create a new user
            $data=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'email_verified_at'=>now(),
                'api_token'=>Str::random(60),
                'password'=>Hash::make(12345678)
            ]);

            $user=User::where('email',$request->email)->get()->first();
            return \Response::json(['success'=>'login success ','userData'=>$user]);
        }
        return redirect()->to('/home');
    }
    public function sendEmail(Request $request){
        $validateRules=[
            'email'         =>  'required',
        ];
        $newFilesArray=[];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $user=User::whereEmail($request->email)->first();
        if($user==null){
            return \Response::json(['errors'=>'Email not existed']);
        }
        $code=Str::random(60);
        $user->passwordResetCode=$code;
        $user->save();
        LoginController::sendEmailToUser($user,$code);
        return  \Response::json(['success'=>'Reset code sent to your Email']);
    }
    public function sendEmailToUser($user,$code){
        Mail::send('emails.forgot',['user'=>$user, 'code'=>$code,],
            function ($message)use ($user){
                $message->to($user->email);
                $message->subject($user->name,'reset your password.');
            }
        );
    }

}
