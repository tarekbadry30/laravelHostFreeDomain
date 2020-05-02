<?php

namespace App\Http\Controllers;

use App\comments;
use App\gallary;
use App\notification;
use App\posts;
use App\reply;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class notificationController extends Controller
{
    public function postDetails(Request $request){

        $posts=posts::where('id',$request->post_id)->first();
        if($posts!=null){
            if(Auth::id()==$posts->user_id){
                $notificationUpdate=notification::where([['post_id','=',$posts->id],['status','=','notRead']])->get();
                if($notificationUpdate!=null){
                    foreach ($notificationUpdate as $notItem){
                        $notItem->update(['status'=>'Read']);
                    }
                }
            }
            $images = gallary::where('post_id', $posts->id)->get();
            if ($images != null) {
                $posts->allImages = $images;
                $posts->mainImage = gallary::where('post_id', $posts->id)->first()->img_url;
            }
            else{
                $posts->mainImage = 'img/no-image.png';
                $posts->allImages = 'img/no-image.png';
            }
            $comments = comments::where('comments.post_id',$posts->id )->orderBy('id','DESC')
                ->get();
            if($comments!=null){
                foreach ($comments as $comment) {
                    $comment->user=User::find($comment->user_id)->name;
                    $replies = reply::where('comment_id',$comment->id )->orderBy('id','DESC')->get();
                    if($replies !=null){
                        foreach ($replies as $reply) {
                            $reply->user=User::find($reply->user_id)->name;
                        }
                        $comment->replies=$replies;
                    }
                    else{
                        $comment->replies='no';
                    }


                }
                $posts->allComments=$comments;
            }
            else{
                $posts->allComments='';
            }
            $notification=notification::notiUnreadedCount();

            return view('postDetails',['posts'=>$posts,'page_title'=>'post Details','notification'=>$notification]);
        }
        else{
            return 'you dont have permission to access this page';
        }

    }
    public function notificationIndex(Request $request)
    {
        if($request->filterType==''){
            $page_title='All notifications';
        }
        else{
            $page_title=$request->filterType.' notifications';
        }
        $notification=notification::notiUnreadedCount(Auth::user()->id);
        $Allnotification=notification::Allnotification($request->filterType,Auth::user()->id);
        return view('notification',['page_title'=>$page_title,'Allnotifications'=>$Allnotification,'notification'=>$notification]);
    }

}
