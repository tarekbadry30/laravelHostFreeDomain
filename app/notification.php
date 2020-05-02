<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DB;

class notification extends Model
{
    protected $guarded = [];
    protected $fillable=["not_title","not_from_id","not_to_id","comment_id","status","post_id"];

    public static function notiUnreadedCount($user_id=null){
        if($user_id==null){
            Auth::user()->id;
        }
        return $notification= DB::table('notifications')->where([['status','=','notRead'],['not_to_id','=',$user_id]])->count();
    }
    public static function AllnotiUnreaded($user_id=null){
        if($user_id==null){
            Auth::user()->id;
        }
        return $notification= DB::table('notifications')->where([['status','=','notRead'],['not_to_id','=',$user_id]])->orderBy('id','DESC')->get();
    }


    public static function Allnotification($filterType=null,$user_id=null){
        if($user_id==null){
            Auth::id();
        }
        $notification = null;
        if($filterType != null){
            $notification=notification::where('not_to_id','=',$user_id)->where('status','=',$filterType)->orderBy('id','DESC')->get();
        }
        else{
            $notification=notification::where('not_to_id','=',$user_id)->orderBy('id','DESC')->get();
        }
        if($notification !=null){
            return $notification;
        }
        else{
            return 'no notifications founded';
        }
    }


}
