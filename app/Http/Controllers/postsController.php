<?php

namespace App\Http\Controllers;


use App\comments;
use App\gallary;
use App\notification;
use App\posts;
use App\rent;
use App\reply;
use App\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Illuminate\Http\Request;

class postsController extends Controller
{
    public function postsIndex(Request $request)
    {
        if(Auth::check() ){
            $notification=notification::AllnotiUnreaded(Auth::user()->id);
        }
        else{
            $notification=[];
        }

        $request->filterType;
        $posts=posts::Active($request->filterType);
        if (count($posts) >10)
        {
            $randomPosts = posts::where('status','=','active')->get()->random(10);
            foreach ($randomPosts as $post) {
                $post->username=User::find($post->user_id)->name;
                $images = gallary::where('post_id', $post->id)->first();
                if ($images != null) {
                    $post->mainImage = $images->img_url;
                }
                else{
                    $post->mainImage = 'img/no-image.png';
                }
            }
        }
        else{
            $randomPosts = $posts;
        }
        $page_title = $request->filterType==null ? 'all_posts' : $request->filterType;
        return view('posts',['posts'=>$posts,'randomPosts'=>$randomPosts,'page_title'=>$page_title,'notification'=>count($notification),'notificationContent'=>$notification]);
    }
    public function searchPosts(Request $request)
    {
        //return $request;
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

        if($posts !=null){
            foreach ($posts as $post) {
                $post->username=User::find($post->user_id)->name;
                $images = gallary::where('post_id', $post->id)->first();
                if ($images != null) {
                    $post->mainImage = $images->img_url;
                }
                else{
                    $post->mainImage = 'img/no-image.png';
                }
            }
        }
        if(Auth::check() ){
            $notification=notification::AllnotiUnreaded(Auth::user()->id);
        }
        else{
            $notification=[];
        }
        if(count($posts )!= 0){
            $page_title = $type.' search for : '.$seachText;
        }
        else{
            $page_title = $type.' no result for : '.$seachText;
        }
        return view('search',['posts'=>$posts,'seachText'=>$page_title,'page_title'=>'search for : '.$seachText,'notification'=>count($notification),'notificationContent'=>$notification]);
    }
    public function postDetails(Request $request){

        $posts=posts::where('id',$request->post_id)->first();
        if($posts!=null ) {
            if ($posts->status == 'disactive' && $posts->user_id != Auth::id()) {
                return view('error',['message'=>'hiddenByUser']);
            }
            if($posts->blocked ==true){
                return view('error',['message'=>'blockedByAdmin']);
            }

            $posts->username=User::find($posts->user_id)->name;

                $notificationUpdate=notification::where([
                    ['post_id','=',$posts->id],
                    ['status','=','notRead'],
                    ['not_to_id','=',Auth::id()]
                ])->get();
                if($notificationUpdate!=null){
                    foreach ($notificationUpdate as $notItem){
                        $notItem->update(['status'=>'Read']);
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
            if(Auth::check() ){
                $notification=notification::AllnotiUnreaded(Auth::user()->id);
            }
            else{
                $notification=[];
            }
            return view('postDetails',[
                'posts'=>$posts,
                'page_title'=>'post Details',
                'notification'=>count($notification),
                'notificationContent'=>$notification
                ]);
        }
        else{
            return 'you dont have permission to access this page';
        }

    }
    public function addComment(Request $request){

        $posts=posts::where('id',$request->post_id)->first();
        if($posts!=null){

            $validateRules=[
                'post_id'       =>  'required',
                'comment'       =>  'required',
            ];
            $error= Validator::make($request->all(),$validateRules);
            if($error->fails()){
                return \Response::json(['errors'=>$error->errors()->all()]);
            }
            $comment = new comments(['post_id'=>$request->post_id,'com_content'=>$request->comment,'user_id'=>auth()->user()->id]);
            $comment->save();
            $postName= $posts->post_name;
            if(auth()->user()->id != $posts->user_id){
                $notification = new notification([
                    'not_title'   => 'there is a comment on your post : "'.$postName.'" from : "'.Auth::user()->name.'"',
                    'not_from_id' =>  auth()->user()->id,
                    'not_to_id'   =>  $posts->user_id,
                    'comment_id'  =>  $comment->id,
                    'post_id'     =>  $posts->id,
                    'status'      =>  'notRead',

                ]);
                $notification->save();
            }
            return back();
        }
        else{
            return 'you dont have permission to access this page';
        }

    }
    public function replyComment(Request $request){

        $comments=comments::where('id',$request->comment_id)->first();
        if($comments!=null){

            $validateRules=[
                'comment_id'    =>  'required',
                'comment'       =>  'required',
            ];
            $error= Validator::make($request->all(),$validateRules);
            if($error->fails()){
                return \Response::json(['errors'=>$error->errors()->all()]);
            }
            $reply = new reply(['comment_id'=>$request->comment_id,'com_content'=>$request->comment,'user_id'=>auth()->user()->id]);
            $reply->save();
            $posts=posts::where('id',$comments->post_id)->first();
            if(Auth::id() == $posts->user_id){
                $to_id= $comments->user_id;
            }
            else{
                $to_id=$posts->user_id;
            }
            $notification = new notification([
                'not_title'   => 'there is a reply on your comment on post : "'.$posts->post_name.'" from : "'.Auth::user()->name.'"',
                'not_from_id' =>  auth()->user()->id,
                'not_to_id'   =>  $to_id,
                'comment_id'  =>  $comments->id,
                'post_id'     =>  $posts->id,
                'status'      =>  'notRead',
            ]);
            $notification->save();


            return back();
        }
        else{
            return 'you dont have permission to access this page';
        }

    }
    public function editPost(Request $request){

        $posts=posts::where([['user_id',auth()->id()],['id',$request->post_id]])->first();
        if($posts!=null){
            if(Auth::check() ){
                $notification=notification::AllnotiUnreaded(Auth::user()->id);
            }
            else{
                $notification=[];
            }
            return view('editPost',[
                'posts'=>$posts,
                'notification'=>count($notification),
                'notificationContent'=>$notification,
                'page_title'=>'edit my post']);
        }
        else{
            return 'you dont have permission to access this page';
        }

    }
    public function deleteComment(Request $request){
        $deleted = comments::destroy($request->comment_id);
        if ($deleted) {
            return back();
        } else {
            return response()->json([
                'error' => 'not deleted ',
            ]);
        }

    }
    public function disablePost(Request $request){
        $posts = posts::where([['user_id','=',auth()->id()],['id','=',$request->post_id]])->first();
        if($posts!=null){

            if($posts->status=='active' ){
                $newStatus='';
                $newStatus='disactive';
            }
            else{
                $newStatus='active';
            }
            posts::where([['user_id','=',auth()->id()],['id','=',$request->post_id]])->update(['status' => $newStatus]);
            return back();
        }
        else{
            return 'you dont have permission to access this page';
        }

    }
    public function deletePost(Request $request){

        $posts=posts::where([['user_id',auth()->id()],['id',$request->post_id]])->first();
        if($posts!=null){
            $fileToDelete = new Filesystem;
            $fileToDelete->cleanDirectory( public_path('img/'.$posts->user_id.'/posts/'.$posts->type.'/'.$posts->id) );
            postsController::deleteDirectory(public_path('img/'.$posts->user_id.'/posts/'.$posts->type.'/'.$posts->id));
            if($posts->delete()){
                return redirect(url('/'));
                return \Response::json(['success'=>'delete success']);
            }
            else{
                return \Response::json(['errors'=>'not deleted']);
            }
        }

        else{
            return \Response::json(['errors'=>'not found']);
        }

    }
    public function myPostsIndex()
    {
        $ActiveRentPosts=posts::myRentActive();
        $DisActiveRentPosts=posts::myRentDisActive();
        $ActiveSellPosts=posts::mySelActive();
        $DisActiveSellPosts=posts::mySelDisActive();
        if(Auth::check() ){
            $notification=notification::AllnotiUnreaded(Auth::user()->id);
        }
        else{
            $notification=[];
        }
        return view('profile',[
            'ActiveRentPosts'=>$ActiveRentPosts,
            'notification'=>count($notification),
            'notificationContent'=>$notification,
            'DisActiveRentPosts'=>$DisActiveRentPosts,
            'ActiveSellPosts'=>$ActiveSellPosts,
            'DisActiveSellPosts'=>$DisActiveSellPosts,
        ]);
    }
    public function addPost()
    {
        if(Auth::check() ){
            $notification=notification::AllnotiUnreaded(Auth::user()->id);
        }
        else{
            $notification=[];
        }
        return view('add_post',[
                    'page_title'=>'post Details',
                    'notification'=>count($notification),
                    'notificationContent'=>$notification
        ]);
        return view('add_post');
    }
    public function insertPost( Request $request){
        $user_id = auth()->user()->id;

        $validateRules=[
            'post_name'     =>  'required',
            'post_desc'     =>  'required',
            'post_address'  =>  'required',
            'type'          =>  'required',
            'mobile'        =>  'required',
            'price'         =>  'required',
            'email'         =>  'required',

        ];
        $newFilesArray=[];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        if($files=$request->file('img')) {
            $validateRules = [
                'img' => 'required',
                'img.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
            foreach ($files as $file) {
                $error = Validator::make($request->all(), $validateRules);
                if ($error->fails()) {
                    return \Response::json(['errors' => $error->errors()->all()]);
                }

            }

            $post_id = posts::create(
                [   'user_id'   => $user_id,
                    'post_name' => $request->post_name,
                    'desc'      => $request->post_desc,
                    'address'   => $request->post_address,
                    'price'     => $request->price,
                    'email'     => $request->email,
                    'phone'     => $request->mobile,
                    'type'      => $request->type,
                ]
            )->id;

            foreach ($files as $file) {

                $newFile = 'img' . time().rand(1,100) . '.' . $file->getClientOriginalExtension();
                $newFilesArray[] = $newFile;
                $file->move(public_path('img/' . $user_id . '/posts/' . $request->type . '/' . $post_id), $newFile);
                $img_url = 'img/' . $user_id . '/posts/' . $request->type . '/' . $post_id . '/' . $newFile;
                //return $files;
                $newGallary = gallary::create(
                    [   'post_id' => $post_id,
                        'img_url' => $img_url,
                    ]
                )->id;
            }
            return redirect(route('postDetails',['post_id'=>$post_id]));
            return \Response::json(['success' => 'inserted success']);

        }
        return \Response::json(['error' => 'one image required at least']);


    }
    public function updatePost( Request $request){
        $validateRules=[
            'id'            =>  'required',
            'post_name'     =>  'required',
            'post_desc'     =>  'required',
            'post_address'  =>  'required',
            'price'         =>  'required',
            'mobile'        =>  'required',
            'email'         =>  'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }

        $user_id = auth()->user()->id;
        $update = \DB::table('posts') ->where([ ['id', $request->id],['user_id',$user_id] ]) ->limit(1) ->update(
            [   'user_id'       => $user_id,
                'post_name'     => $request->post_name,
                'desc'          => $request->post_desc,
                'address'       => $request->post_address,
                'price'         => $request->price,
                'email'         => $request->email,
                'phone'         => $request->mobile,
            ]
        );
        return redirect(route('postDetails',['post_id'=>$request->id]));
        return \Response::json(['success'=>'updated success']);



    }

    ///////////////////apis/////////////////////
    public function indexPostsApi(){
        return$posts=posts::Active();
    }
    public function myRentActiveAPI(Request $request)
    {

        $validateRules=[
            'api_token'   =>  'required',
        ];
        $error= \Illuminate\Support\Facades\Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $user=User::where([['api_token','=',$request->api_token],['email_verified_at','!=','']])->get()->first();
        if($user==null){
            return \Response::json(['errors'=>'error login','message'=>'please login and active your account to access']);
        }
        $posts=posts::myRentActive($user->id);
        return \Response::json(['my Active Rent'=>$posts]);
    }
    public function myRentDisActiveAPI(Request $request)
    {

        $validateRules=[
            'api_token'   =>  'required',

        ];
        $error= \Illuminate\Support\Facades\Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $user=User::where([['api_token','=',$request->api_token],['email_verified_at','!=','']])->get()->first();
        if($user==null){
            return \Response::json(['errors'=>'error login','message'=>'please login and active your account to access']);
        }
        $posts=posts::myRentDisActive($user->id);
        return \Response::json(['my DisActive Rents'=>$posts]);
    }
    public function mySellActiveAPI(Request $request)
    {

        $validateRules=[
            'api_token'   =>  'required',

        ];
        $error= \Illuminate\Support\Facades\Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $user=User::where([['api_token','=',$request->api_token],['email_verified_at','!=','']])->get()->first();
        if($user==null){
            return \Response::json(['errors'=>'error login','message'=>'please login and active your account to access']);
        }
        $posts=posts::mySelActive($user->id);
        return \Response::json(['my Active sell'=>$posts]);
    }
    public function mySellDisActiveAPI(Request $request)
    {

        $validateRules=[
            'api_token'   =>  'required',
        ];
        $error= \Illuminate\Support\Facades\Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $user=User::where([['api_token','=',$request->api_token],['email_verified_at','!=','']])->get()->first();
        if($user==null){
            return \Response::json(['errors'=>'error login','message'=>'please login and active your account to access']);
        }
        $posts=posts::mySelDisActive($user->id);
        return \Response::json(['my DisActive Sell'=>$posts]);
    }
    public function postDetailsAPI(Request $request){

        $posts=posts::where('id',$request->post_id)->first();
        if($posts!=null){
            if(Auth::id()==$posts->user_id){
                $notificationUpdate=notification::where([
                    ['post_id','=',$posts->id],
                    ['status','=','notRead'],
                    ['not_to_id','=',Auth::id()]
                ])->get();
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
            return \Response::json(['post'=>$posts]);

        }
        else{
            return 'you dont have permission to access this page';
        }

    }

    public function insertCommentAPI(Request $request)
    {

        $validateRules = [
            'api_token' => 'required',
        ];
        $error = \Illuminate\Support\Facades\Validator::make($request->all(), $validateRules);
        if ($error->fails()) {
            return \Response::json(['errors' => $error->errors()->all()]);
        }
        $user = User::where('api_token', $request->api_token)->get()->first();
        if ($user == null) {
            return \Response::json(['errors' => 'error login', 'message' => 'please login and active your account to access']);
        }

        $posts=posts::where('id',$request->post_id)->first();
        if($posts!=null){

            $validateRules=[
                'post_id'       =>  'required',
                'comment'       =>  'required',
            ];
            $error= Validator::make($request->all(),$validateRules);
            if($error->fails()){
                return \Response::json(['errors'=>$error->errors()->all()]);
            }
            $comment = new comments(['post_id'=>$request->post_id,'com_content'=>$request->comment,'user_id'=>$user->id]);
            $comment->save();
            $postName= $posts->post_name;
            if($user->id != $posts->user_id){
                $notification = new notification([
                    'not_title'   => 'there is a comment on your post : "'.$postName.'" from : "'.$user->name.'"',
                    'not_from_id' =>  $user->id,
                    'not_to_id'   =>  $posts->user_id,
                    'comment_id'  =>  $comment->id,
                    'post_id'     =>  $posts->id,
                    'status'      =>  'notRead',

                ]);
                $notification->save();
            }
            return \Response::json(['success'=>'comment inserted ']);
        }
        else{
            return \Response::json(['error'=>'post not found ']);

        }
    }
    public function deleteCommentAPI(Request $request){
        $validateRules = [
            'api_token' => 'required',
        ];
        $error = \Illuminate\Support\Facades\Validator::make($request->all(), $validateRules);
        if ($error->fails()) {
            return \Response::json(['errors' => $error->errors()->all()]);
        }
        $user = User::where('api_token', $request->api_token)->get()->first();
        if ($user == null) {
            return \Response::json(['errors' => 'error login', 'message' => 'please login and active your account to access']);
        }
        if(comments::where('id',$request->comment_id)->where('user_id',$user->id))
        {
            $deleted = comments::destroy($request->comment_id);
            if ($deleted) {
                return response()->json([
                    'success' => 'comment deleted ',
                ]);
            } else {
                return response()->json([
                    'error' => 'not deleted ',
                ]);
            }
        }


    }
    public function replyCommentAPI(Request $request){
        $validateRules = [
            'api_token' => 'required',
        ];
        $error = \Illuminate\Support\Facades\Validator::make($request->all(), $validateRules);
        if ($error->fails()) {
            return \Response::json(['errors' => $error->errors()->all()]);
        }
        $user = User::where('api_token', $request->api_token)->get()->first();
        if ($user == null) {
            return \Response::json(['errors' => 'error login', 'message' => 'please login and active your account to access']);
        }

        $comments=comments::where('id',$request->comment_id)->first();
        if($comments!=null){
            $post_id=$comments->post_id;
            $owner_id= posts::where('id',$post_id)->first()->user_id;
            if($owner_id!=$user->id){
                return \Response::json(['errors'=>'not permission','message'=>'you dont have permission to replay']);
            }
            $validateRules=[
                'comment_id'    =>  'required',
                'replay'       =>  'required',
            ];
            $error= Validator::make($request->all(),$validateRules);
            if($error->fails()){
                return \Response::json(['errors'=>$error->errors()->all()]);
            }
            $reply = new reply(['comment_id'=>$request->comment_id,'com_content'=>$request->replay,'user_id'=>$user->id]);
            $reply->save();
            $posts=posts::where('id',$comments->post_id)->first();
            if(Auth::id() != $comments->user_id){
                $notification = new notification([
                    'not_title'   => 'there is a reply on your comment on post : "'.$posts->post_name.'" from : "'.$user->name.'"',
                    'not_from_id' =>  $user->id,
                    'not_to_id'   =>  $comments->user_id,
                    'comment_id'  =>  $comments->id,
                    'post_id'     =>  $posts->id,
                    'status'      =>  'notRead',
                ]);
                $notification->save();
            }

            return \Response::json(['success'=>'replay inserted']);
        }
        else{
            return \Response::json(['error'=>'not found','message'=>'comment not found to replay ']);
        }

    }

    public function insertPostAPI( Request $request){
        $validateRules = [
            'api_token' => 'required',
        ];
        $error = \Illuminate\Support\Facades\Validator::make($request->all(), $validateRules);
        if ($error->fails()) {
            return \Response::json(['errors' => $error->errors()->all()]);
        }
        $user = User::where('api_token', $request->api_token)->get()->first();
        if ($user == null) {
            return \Response::json(['errors' => 'error login', 'message' => 'please login and active your account to access']);
        }
        $user_id = $user->id;

        $validateRules=[
            'post_name'     =>  'required',
            'post_desc'     =>  'required',
            'post_address'  =>  'required',
            'type'          =>  'required',
            'mobile'        =>  'required',
            'email'         =>  'required',

        ];
        $newFilesArray=[];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        if($files=$request->file('img')) {
            $validateRules = [
                'img' => 'required',
                'img.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
            foreach ($files as $file) {
                $error = Validator::make($request->all(), $validateRules);
                if ($error->fails()) {
                    return \Response::json(['errors' => $error->errors()->all()]);
                }

            }

            $post_id = posts::create(
                [   'user_id' => $user_id,
                    'post_name' => $request->post_name,
                    'desc' => $request->post_desc,
                    'address' => $request->post_address,
                    'price' => $request->price,
                    'email' => $request->email,
                    'phone' => $request->mobile,
                    'type' => $request->type,
                ]
            )->id;

            foreach ($files as $file) {

                $newFile = 'img' . time().rand(1,100) . '.' . $file->getClientOriginalExtension();
                $newFilesArray[] = $newFile;
                $file->move(public_path('img/' . $user_id . '/posts/' . $request->type . '/' . $post_id), $newFile);
                $img_url = 'img/' . $user_id . '/posts/' . $request->type . '/' . $post_id . '/' . $newFile;
                //return $files;
                $newGallary = gallary::create(
                    [   'post_id' => $post_id,
                        'img_url' => $img_url,
                    ]
                )->id;
            }

            return \Response::json(['success' => 'inserted success']);

        }
        else{
            $post_id = posts::create(
                [   'user_id' => $user_id,
                    'post_name' => $request->post_name,
                    'desc' => $request->post_desc,
                    'address' => $request->post_address,
                    'price' => $request->price,
                    'email' => $request->email,
                    'phone' => $request->mobile,
                    'type' => $request->type,
                ]
            )->id;
        }
        return \Response::json(['success' => 'inserted success','post_id'=>$post_id]);


    }
    public function editPostAPI(Request $request){
        $validateRules = [
            'api_token' => 'required',

        ];
        $error = \Illuminate\Support\Facades\Validator::make($request->all(), $validateRules);
        if ($error->fails()) {
            return \Response::json(['errors' => $error->errors()->all()]);
        }
        $user = User::where('api_token', $request->api_token)->get()->first();
        if ($user == null) {
            return \Response::json(['errors' => 'error login', 'message' => 'please login and active your account to access']);
        }

        $posts=posts::where([['user_id',$user->id],['id',$request->post_id]])->first();
        if($posts!=null){
            return \Response::json(['postData'=>$posts]);
        }
        else{
            return \Response::json(['errors' => 'not found', 'message' => 'post not found or you dont have permission to access']);
        }

    }
    public function updatePostAPI( Request $request){
        $validateRules = [
            'api_token' => 'required',
        ];
        $error = \Illuminate\Support\Facades\Validator::make($request->all(), $validateRules);
        if ($error->fails()) {
            return \Response::json(['errors' => $error->errors()->all()]);
        }
        $user = User::where('api_token', $request->api_token)->get()->first();
        if ($user == null) {
            return \Response::json(['errors' => 'error login', 'message' => 'please login and active your account to access']);
        }

        $validateRules=[
            'post_id'       =>  'required',
            'post_name'     =>  'required',
            'post_desc'     =>  'required',
            'post_address'  =>  'required',
            'mobile'        =>  'required',
            'email'         =>  'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }

        $user_id = $user->id;
        $update = \DB::table('posts') ->where([ ['id', $request->id],['user_id',$user_id] ]) ->limit(1) ->update(
            [   'user_id'       => $user_id,
                'post_name'     => $request->post_name,
                'desc'          => $request->post_desc,
                'address'       => $request->post_address,
                'price'         => $request->price,
                'email'         => $request->email,
                'phone'         => $request->mobile,
            ]
        );

        return \Response::json(['success'=>'updated success']);



    }
    public function deletePostAPI(Request $request){
        $validateRules = [
            'api_token' => 'required',
        ];
        $error = \Illuminate\Support\Facades\Validator::make($request->all(), $validateRules);
        if ($error->fails()) {
            return \Response::json(['errors' => $error->errors()->all()]);
        }
        $user = User::where('api_token', $request->api_token)->get()->first();
        if ($user == null) {
            return \Response::json(['errors' => 'error login', 'message' => 'please login and active your account to access']);
        }
        $posts=posts::where([['user_id',$user->id],['id',$request->post_id]])->first();
        if($posts!=null){
            $fileToDelete = new Filesystem;
            $fileToDelete->cleanDirectory( public_path('img/'.$posts->user_id.'/posts/'.$posts->type.'/'.$posts->id) );
            postsController::deleteDirectory(public_path('img/'.$posts->user_id.'/posts/'.$posts->type.'/'.$posts->id));
            if($posts->delete()){
                return \Response::json(['success'=>'delete success']);
            }
            else{
                return \Response::json(['errors'=>'not deleted']);
            }
        }

        else{
            return \Response::json(['errors'=>'not found']);
        }

    }

    public function myNewNotificationAPI(Request $request){
        $validateRules = [
            'api_token' => 'required',
        ];
        $error = \Illuminate\Support\Facades\Validator::make($request->all(), $validateRules);
        if ($error->fails()) {
            return \Response::json(['errors' => $error->errors()->all()]);
        }
        $user = User::where('api_token', $request->api_token)->get()->first();
        if ($user == null) {
            return \Response::json(['errors' => 'error login', 'message' => 'please login and active your account to access']);
        }
        $notification=notification::AllnotiUnreaded($user->id);
        return \Response::json(['New notification' => $notification]);


    }
    public function myAllNotificationAPI(Request $request){
        $validateRules = [
            'api_token' => 'required',
        ];
        $error = \Illuminate\Support\Facades\Validator::make($request->all(), $validateRules);
        if ($error->fails()) {
            return \Response::json(['errors' => $error->errors()->all()]);
        }
        $user = User::where('api_token', $request->api_token)->get()->first();
        if ($user == null) {
            return \Response::json(['errors' => 'error login', 'message' => 'please login and active your account to access']);
        }
        $notification=notification::AllnotiUnreaded($user->id);
        return \Response::json(['all notification' => $notification]);


    }


}
