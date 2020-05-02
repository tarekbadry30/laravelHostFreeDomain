<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use  DB;
class comments extends Model
{
    protected $guarded = [];
    protected $fillable=["user_id","post_id","com_content",];
    public static function myAllComments($id=null){
        if($id==null){
            $id=Auth::id();
        }
        $comments= DB::table('comments')->where('user_id','=',$id)->get();
        return $comments;
    }
    public static function myAllReplies($id=null){
        if($id==null){
            $id=Auth::id();
        }
        $comments= DB::table('replies')->where('user_id','=',$id)->get();
        return $comments;
    }
    public static function postCommentsCount($id){
        $result=0;
        $comments=comments::where('post_id','=',$id)->get();
        if($comments!=null){
            $result=count($comments);
            foreach ($comments as $comment) {
                $replies= DB::table('replies')->where('comment_id','=',$comment->id)->get();
                $result+=count($replies);
            }

        }
        return $result;
    }

}
