<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Password;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use function GuzzleHttp\Psr7\uri_for;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    public function sendEmail(Request $request){

        //return $request->all();
         $user=User::whereEmail($request->email)->first(); //->frst();
        if($user==null){
            return redirect()->back()->withErrors('email','Email not existed');
        }

        $code=Str::random(60);
        $user->passwordResetCode=$code;
        $user->save();
        ForgotPasswordController::sendEmailToUser($user,$code);
        /*$token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);*/
        return redirect()->back()->with(['success'=>'Reset code sent to your Email']);
    }
    public function sendEmailToUser($user,$code){
        Mail::send('emails.forgot',['user'=>$user, 'code'=>$code,],
            function ($message)use ($user){
            $message->to($user->email);
            $message->subject('reset your password.',$user->name);
            }
        );
    }
    public function requestEmail(){
        return view('auth.passwords.requestEmail');
    }
    public function newPassword(Request $request){

        $validateRules=[
            'email'         =>  'required',
            'username'      =>  'required',
            'code'          =>  'required',
        ];
        $newFilesArray=[];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $user=User::where([
            ['email','=',$request->email],
            ['passwordResetCode','=',$request->code],
            ['name','=',$request->username]
        ])->first();
        if($user==null){
            return view('error',['name'=>$request->username,'email'=>$request->email,'code'=>$request->code,]);
        }
        return view('auth.passwords.resetNewPassword',['name'=>$request->username,'email'=>$request->email,'code'=>$request->code,]);
    }
    public function updateNewPassword(Request $request){
        $validateRules=[
            'email'             =>  'required',
            'username'          =>  'required',
            'code'              =>  'required',
            'newPassword'       =>  'required|min:8',
            'repeatNewPass'     =>  'required|same:newPassword',
            ];
        $newFilesArray=[];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return redirect()->back()->with(['errors' => $error->errors()->all()]);
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $user=User::where([
            ['email','=',$request->email],
            ['passwordResetCode','=',$request->code],
            ['name','=',$request->username]
        ])->first();
        if($user==null){
            return redirect()->back()->with('error','data not match');
        }
        $code=Str::random(60);
        $user->passwordResetCode=$code;
        $user->password=Hash::make($request->newPassword);
        $user->save();
       // auth()->login($user, true);
       // return redirect(url('/'));
        return redirect(url('/login'));
    }
}
