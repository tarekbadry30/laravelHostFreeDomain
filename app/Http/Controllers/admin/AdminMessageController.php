<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;

class AdminMessageController extends Controller
{
    public function sendEmail(Request $request){

        $validateRules=[
            'email'         =>  'required',
            'name'          =>  'required',
            'phone'         =>  'required',
            'message'       =>  'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return redirect()->back()->with('errors','please fill all data');
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
         $data = array( 'email' => $request->email, 'user' => $request->name,
            'phone' => $request->phone, 'messageText' => $request->message );
        Mail::send( 'emails.message', $data, function( $message ) use ($data)
        {
            $message->to( $data['email'] )->subject( 'new message!' );
        });

        /*Mail::send('emails.message',['user'=>'re', 'email'=>'rt','phone'=>'rt','message'=>'rete'],
            function ($message){
                $message->to('t@t.com');
                $message->subject('new message from');
            }
        );*/
        return redirect()->back()->with(['success'=>'message sent success']);
    }
    public function sendEmailToUser(Request $request){

    }
}
