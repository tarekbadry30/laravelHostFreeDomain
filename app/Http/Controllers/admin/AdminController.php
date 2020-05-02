<?php

namespace App\Http\Controllers\admin;

use App\comments;
use App\gallary;
use App\Http\Controllers\Controller;
use App\Http\Controllers\postsController;
use DB;
use App\posts_reports;
use App\reply;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\posts;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function indexDashboard(){
        $AllpostsCount=count(posts::All());
        $rentPostsCount=count(posts::allRentPosts());
        $rentActivePostsCount=count(posts::activeRent());
        $selPostsCount=count(posts::allSelPosts());
        $selActivePostsCount=count(posts::activeSel());
        $commentsCount=count(comments::all());
        $usersCount=count(User::all());
        $result = [];
        $result['AllpostsCount']=$AllpostsCount;
        $result['rentPostsCount']=$rentPostsCount;
        $result['rentActivePostsCount']=$rentActivePostsCount;
        $result['selPostsCount']=$selPostsCount;
        $result['selActivePostsCount']=$selActivePostsCount;
        $result['usersCount']=$usersCount;
        return view('admin.dashboarde',['result'=>$result]);

    }

    public function usersIndex(){
        $users=User::all();
        $activeUsers=[];
        $disActiveUsers=[];
        if($users!=null){
            foreach ($users as $user) {
                $user->postsCount=count(posts::myAllPosts($user->id));
                $user->commentsCount=count(comments::myAllComments($user->id)) + count(comments::myAllReplies($user->id));
                if($user->status=='active'){
                    $activeUsers[]=$user;
                }
                else{
                    $disActiveUsers[]=$user;
                }
             }
        }
        /*$result=[];
        $result['activeUsers']=$activeUsers;
        $result['disActiveUsers']=$disActiveUsers;*/
        return view('admin.users',['activeUsers'=>$activeUsers,'disActiveUsers'=>$disActiveUsers]);
        //return $result;

    }
    public function controlUser(Request $request){
        $user_id=$request->user_id;
        if($user=User::find($user_id)){
            if($user->status=='active' ){
                $newStatus='blocked';
            }
            else{
                $newStatus='active';
            }
            $user->status=$newStatus;
            $user->save();
            return \Response::json(['success'=>'user updated']);

        }
        else{
            return \Response::json(['error'=>'user not found']);
        }
    }
    public function deleteUser(Request $request){
        $user_id=$request->user_id;

        $fileToDelete = new Filesystem;
        $fileToDelete->cleanDirectory( public_path('img/'.$user_id) );
        postsController::deleteDirectory(public_path('img/'.$user_id));
        if($user=User::find($user_id)){
            $user->delete();
            return \Response::json(['success'=>'user deleted']);
        }
        else{
            return \Response::json(['error'=>'user not found']);
        }
        }
    public function userProfile(Request $request){
        if($user=User::find($request->user_id)) {
            //return $user;
            $ActiveRentPosts = posts::myRentActive($request->user_id);
            $DisActiveRentPosts = posts::myRentDisActive($request->user_id);
            $ActiveSellPosts = posts::mySelActive($request->user_id);
            $DisActiveSellPosts = posts::mySelDisActive($request->user_id);
            return view('admin.userProfile', [
                'user'              =>$user,
                'ActiveRentPosts'   => $ActiveRentPosts,
                'DisActiveRentPosts'=> $DisActiveRentPosts,
                'ActiveSellPosts'   => $ActiveSellPosts,
                'DisActiveSellPosts'=> $DisActiveSellPosts,
            ]);
        }
        else{
            return \Response::json(['error'=>'user not found']);
        }
    }

    public function postsIndex(){
        $rentActive=[];
        $selActive=[];
        $rentDisActive=[];
        $selDisActive=[];
        $result=[];
        $posts=posts::all();
        if($posts!=null){
            foreach ($posts as $post) {
                $images = gallary::where('post_id', $post->id)->get();
                count($images);
                if ($images != null) {
                    $post->mainImage = $images->first()->img_url;
                }
                else{
                    $post->mainImage = 'img/no-image.png';
                }
                $post->imgCount=count($images);
                $post->user=User::where('id','=',$post->user_id)->get()->first()->name;
                if($post->type=='rent'){
                    if($post->status=='active'){
                        $rentActive[]=$post;
                    }
                    else{
                        $rentDisActive[]=$post;
                    }
                }
                else{
                    if($post->status=='active'){
                        $selActive[]=$post;
                    }
                    else{
                        $selDisActive[]=$post;
                    }
                }


            }
        }
        $result['sel']['active']=$selActive;
        $result['rent']['active']=$rentActive;
        $result['rent']['disActive']=$rentDisActive;
        $result['sel']['disActive']=$selDisActive;
        //return $result;
        return view('admin.adminPosts',['posts'=>$result,'page_title'=>'all_posts']);
    }
    public function searchPosts(Request $request)
    {
        $rentActive=[];
        $selActive=[];
        $rentDisActive=[];
        $selDisActive=[];
        $result=[];
        $serachOption=$request->searchOption;
        $seachText=$request->filterType;
        $type='';
        if($serachOption != null){
            $posts=DB::table('posts')
                ->where([['post_name','like','%'.$seachText.'%'],['status','=','active'],['type','=',$serachOption]])
                ->orWhere([['desc','like','%'.$seachText.'%'],['status','=','active'],['type','=',$serachOption]])
                ->orWhere([['address','like','%'.$seachText.'%'],['status','=','active'],['type','=',$serachOption]])
                ->orWhere([['price','like','%'.$seachText.'%'],['status','=','active'],['type','=',$serachOption]])
                ->orWhere([['email','like','%'.$seachText.'%'],['status','=','active'],['type','=',$serachOption]])
                ->orWhere([['type','like','%'.$seachText.'%'],['status','=','active'],['type','=',$serachOption]])
                ->orWhere([['phone','like','%'.$seachText.'%'],['status','=','active'],['type','=',$serachOption]])
                ->orderBy('id','DESC')->get();
            $type=$serachOption;
        }
        else{
            $posts=DB::table('posts')
                ->where([['post_name','like','%'.$seachText.'%'],['status','=','active']])
                ->orWhere([['desc','like','%'.$seachText.'%'],['status','=','active']])
                ->orWhere([['address','like','%'.$seachText.'%'],['status','=','active']])
                ->orWhere([['price','like','%'.$seachText.'%'],['status','=','active']])
                ->orWhere([['email','like','%'.$seachText.'%'],['status','=','active']])
                ->orWhere([['type','like','%'.$seachText.'%'],['status','=','active']])
                ->orWhere([['phone','like','%'.$seachText.'%'],['status','=','active']])
                ->orderBy('id','DESC')->get();
        }

        if($posts!=null){
            foreach ($posts as $post) {
                $images = gallary::where('post_id', $post->id)->get();
                count($images);
                if ($images != null) {
                    $post->mainImage = $images->first()->img_url;
                }
                else{
                    $post->mainImage = 'img/no-image.png';
                }
                $post->imgCount=count($images);
                $post->user=User::where('id','=',$post->user_id)->get()->first()->name;
                if($post->type=='rent'){
                    if($post->status=='active'){
                        $rentActive[]=$post;
                    }
                    else{
                        $rentDisActive[]=$post;
                    }
                }
                else{
                    if($post->status=='active'){
                        $selActive[]=$post;
                    }
                    else{
                        $selDisActive[]=$post;
                    }
                }


            }
        }
        $result['sel']['active']=$selActive;
        $result['rent']['active']=$rentActive;
        $result['rent']['disActive']=$rentDisActive;
        $result['sel']['disActive']=$selDisActive;
        //return $result;
        if(count($posts )!= 0){
            $page_title = $type.' search for : '.$seachText;
        }
        else{
            $page_title = $type.' no result for : '.$seachText;
        }
        return view('admin.adminPosts',['posts'=>$result,'page_title'=>$page_title]);
    }

    public function postDetails(Request $request){

        $posts=posts::where('id',$request->post_id)->first();
        if($posts!=null ) {
            $posts->username=User::find($posts->user_id)->name;
            $reportsUpdate=posts_reports::where([
                ['post_id','=',$posts->id],
                ['status','=','notRead'],
            ])->get();
            if($reportsUpdate!=null){
                foreach ($reportsUpdate as $reportItem){
                    $reportItem->update(['status'=>'read']);
                }
            }
            $images = gallary::where('post_id', $posts->id)->get();
            if (count($images) != 0) {
                $posts->allImages = $images;
                $posts->mainImage = gallary::where('post_id', $posts->id)->first()->img_url;
            }
            else{
                $posts->mainImage = 'img/no-image.png';
                $images = new gallary();
                $images->img_url='img/no-image.png';
                $posts->allImages = [$images];
            }
            $comments = comments::where('comments.post_id',$posts->id )->orderBy('id','ASC')
                ->get();
            if($comments!=null){
                foreach ($comments as $comment) {
                    $comment->user=User::find($comment->user_id)->name;
                    $replies = reply::where('comment_id',$comment->id )->orderBy('id','ASC')->get();
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

            return view('admin.AdminPostDetails',[
                'posts'=>$posts,
                'page_title'=>'post Details',
            ]);
        }
        else{
            return \Response::json(['error'=>'post not found']);
        }

    }

    public function allPostsReport(){
        $postsReport=posts_reports::unRead();
        if(count($postsReport)!=0){
            return $postsReport;
        }
        else{
            return \Response::json(['alert'=>'no reports avilable']);
        }
    }
    public function controlPost(Request $request){
        $posts = posts::where('id','=',$request->post_id)->get()->first();
        if($posts!=null){
            if($posts->blocked==true ){
                $newStatus=false;
                $status='active';
            }
            else{
                $newStatus=true;
                $status='disactive';
            }
            posts::where('id','=',$request->post_id)->update(['blocked' => $newStatus,
                'status' => $status]);
            return redirect()->back();
            return \Response::json(['success'=>'post updated']);

        }
        else{
            return \Response::json(['error'=>'post not found']);
        }

    }
    public function deletePost(Request $request){
        $posts=posts::where('id',$request->post_id)->get()->first();
        if($posts!=null){
            $fileToDelete = new Filesystem;
            $fileToDelete->cleanDirectory( public_path('img/'.$posts->user_id.'/posts/'.$posts->type.'/'.$posts->id) );
            postsController::deleteDirectory(public_path('img/'.$posts->user_id.'/posts/'.$posts->type.'/'.$posts->id));
            if($posts->delete()){
                //return redirect(url('/'));
                return \Response::json(['success'=>'post deleted']);
            }
            else{
                return \Response::json(['errors'=>'post not deleted']);
            }
        }
        else{
            return \Response::json(['errors'=>'post not found']);
        }
    }
    public function deleteComment(Request $request){
        $deleted = comments::destroy($request->comment_id);
        if ($deleted) {
            return \Response::json(['success'=>'comment deleted']);
        } else {
            return \Response::json(['errors'=>'comment not found']);

        }

    }
    public function deleteReplay(Request $request){
        $deleted = reply::destroy($request->replay_id);
        if ($deleted) {
            return \Response::json(['success'=>'comment deleted']);
        } else {
            return \Response::json(['errors'=>'comment not found']);

        }

    }

}
