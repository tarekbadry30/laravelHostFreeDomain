<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\comments;
use Illuminate\Support\Facades\Auth;

class posts extends Model
{
    protected $guarded = [];
    protected $fillable=["user_id","post_name","desc","address","price","email","phone","img_url","type","status","blocked"];
    public static function myRentActive($id=null){
        if($id==null){
            $id=Auth::id();
        }
        $posts= DB::table('posts')->where([['status','=','active'],['type','=','rent'],['user_id','=',$id]])->get();
        foreach ($posts as $post) {
            $post->comments=comments::postcommentsCount($post->id);
            $images = gallary::where('post_id', $post->id)->first();
            if ($images != null) {
                $post->mainImage = $images->img_url;
            }
            else{
                $post->mainImage = 'img/no-image.png';
            }
        }
        return $posts;
    }
    public static function myAllPosts($id=null){
        if($id==null){
            $id=Auth::id();
        }
        $posts= DB::table('posts')->where('user_id','=',$id)->get();
        foreach ($posts as $post) {
            $post->comments=comments::postcommentsCount($post->id);
 $images = gallary::where('post_id', $post->id)->first();
            if ($images != null) {
                $post->mainImage = $images->img_url;
            }
            else{
                $post->mainImage = 'img/no-image.png';
            }
        }
        return $posts;
    }
    public static function mySelActive($id=null){
        if($id==null){
            $id=Auth::id();
        }
        $posts= DB::table('posts')->where([['status','=','active'],['type','=','selling'],['user_id','=',$id]])->get();
        foreach ($posts as $post) {
            $post->comments=comments::postcommentsCount($post->id);
 $images = gallary::where('post_id', $post->id)->first();
            if ($images != null) {
                $post->mainImage = $images->img_url;
            }
            else{
                $post->mainImage = 'img/no-image.png';
            }
        }
        return $posts;
    }
    public static function myRentDisActive($id=null){
        if($id==null){
            $id=Auth::id();
        }
        $posts= DB::table('posts')->where([['status','!=','active'],['type','=','rent'],['user_id','=',$id]])->get();
        foreach ($posts as $post) {
            $post->comments=comments::postcommentsCount($post->id);
 $images = gallary::where('post_id', $post->id)->first();
            if ($images != null) {
                $post->mainImage = $images->img_url;
            }
            else{
                $post->mainImage = 'img/no-image.png';
            }
        }
        return $posts;
    }
    public static function mySelDisActive($id=null){
        if($id==null){
            $id=Auth::id();
        }
        $posts= DB::table('posts')->where([['status','!=','active'],['type','=','selling'],['user_id','=',$id]])->get();
        foreach ($posts as $post) {
            $post->comments=comments::postcommentsCount($post->id);
 $images = gallary::where('post_id', $post->id)->first();
            if ($images != null) {
                $post->mainImage = $images->img_url;
            }
            else{
                $post->mainImage = 'img/no-image.png';
            }
        }
        return $posts;
    }
    public static function Active($filterType=null){
        $posts = null;
        if($filterType != null){
            $posts=DB::table('posts')->where([['status','=','active'],['type','=',$filterType]])->orderBy('id', 'DESC')->get();
        }
        else{
            $posts=DB::table('posts')->where('status','=','active')->orderBy('id', 'DESC')->get();
        }
        if($posts !=null){
            foreach ($posts as $post) {
                $post->username=User::find($post->user_id)->name;
                $post->comments=comments::postcommentsCount($post->id);
                $images = gallary::where('post_id', $post->id)->first();
                if ($images != null) {
                    $post->mainImage = $images->img_url;
                }
                else{
                    $post->mainImage = 'img/no-image.png';
                }
            }
        }
        return $posts;
    }
    public static function DisActive(){
        return DB::table('posts')->where('status','!=','active')->get();
    }
    public static function allRentPosts(){
        return DB::table('posts')->where('type','=','rent')->get();
        //return DB::table('posts')->where([['status','=','active'],['type','=','rent']])->get();
    }
    public static function allSelPosts(){
        return DB::table('posts')->where('type','!=','rent')->get();
        //return DB::table('posts')->where([['status','=','active'],['type','=','rent']])->get();
    }
    public static function activeRent(){
        return DB::table('posts')->where([['status','=','active'],['type','=','rent']])->get();
    }
    public static function activeSel(){
        return DB::table('posts')->where([['status','=','active'],['type','!=','rent']])->get();
    }


}
