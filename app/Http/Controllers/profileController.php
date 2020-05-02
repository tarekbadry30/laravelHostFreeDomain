<?php

namespace App\Http\Controllers;

use App\notification;
use App\posts;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
class profileController extends Controller
{
    public function editMyProfile(){
        if(Auth::check() ){
            $notification=notification::AllnotiUnreaded(Auth::user()->id);
        }
        else{
            $notification=[];
        }
        return view('editProfile',[
            'notification'=>count($notification),
            'notificationContent'=>$notification
        ]);
    }

    public function UpdateMyProfile(Request $request){
        $validateRules=[
            'username'      =>  'required',
            'email'         =>  'required',
            'oldPass'       =>  'required',

        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return redirect()->back()->withErrors(['errors' => $error->errors()->all()]);

            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $credentials  = array('email' => $request->email, 'password' => $request->oldPass);

        if (Auth::attempt($credentials, $request->has('remember'))){
            $dubleUserName=User::where([['name','=',$request->username],['id','!=',Auth::user()->id]])->get()->first();
            if($dubleUserName !=null){
                return redirect()->back()->withErrors(['username' => 'this username allredy existed']);
                return \Response::json(['errors'=>'try another username']);
            }
            $dubleEmail=User::where([['email','=',$request->email],['id','!=',Auth::user()->id]])->get()->first();
            if($dubleEmail !=null){
                return redirect()->back()->withErrors(['email' => 'this email allredy existed']);

                return \Response::json(['errors'=>'the email allredy existed']);
            }
            if($request->newPass != null)
            {
                $validateRules=[
                    'newPass'               =>  'required|min:8',
                    'repeatNewPass'         =>  'required|same:newPass',
                ];
                $error= Validator::make($request->all(),$validateRules);
                if($error->fails()){
                    return redirect()->back()->withErrors(['passwords' => 'the passwords must matches']);
                    return \Response::json(['errors'=>$error->errors()->all()]);
                }
                $update = \DB::table('users') ->where( 'id','=', Auth::user()->id )->limit(1)->update(
                    [
                        'name'              => $request->username,
                        'password'          => Hash::make($request->newPass),
                        'email'             => $request->email,
                    ]
                );
                return redirect(route('myPosts'));


            }
            else{
                $update = \DB::table('users') ->where( 'id','=', Auth::user()->id ) ->limit(1) ->update(
                    [
                        'name'              => $request->username,
                        'password'          => Hash::make($request->oldPass),
                        'email'             => $request->email,
                    ]
                );
                return redirect(route('myPosts'));

            }
        }
        return redirect()->back()->withErrors(['password' => 'incorrect password']);

        return \Response::json(['errors'=>'incorrect password']);

        return redirect(route('postDetails',['post_id'=>$request->id]));
    }

}
