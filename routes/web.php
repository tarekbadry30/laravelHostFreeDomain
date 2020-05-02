<?php

use App\comments;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::get('/','postsController@postsIndex');
Route::get('/token','postsController@token');
Route::get('/sendMessage/',function (){
    return view('sendToAdmin');
});
Route::post('/sendMessage/','admin\AdminMessageController@sendEmail');

Route::post('/login','loginController@login');

Auth::routes(['verify' => true]);

Route::get('/verfiy/phone', function (){
            return view('firebase');
        })->middleware('auth')->name('verification.notice');

Route::post('/verfiy/phone', function (Request $request){
        $validateRules=[
            'phone'     =>  'required|unique:users',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $update = \DB::table('users') ->where('id', Auth::id()) ->limit(1) ->update(
            [   'email_verified_at' => now(),
                'phone' => $request->phone,
            ]
        );
        return redirect(route('home'));
    })->name('ActivePhoneNumber')->middleware('auth');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('vertification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('/password/reset','Auth\forgotPasswordController@requestEmail')->middleware('guest');
Route::post('/password/reset','Auth\forgotPasswordController@sendEmail')->middleware('guest');
Route::get('/password/newPassword/','Auth\forgotPasswordController@newPassword')->middleware('guest');
Route::post('/password/newPassword/','Auth\forgotPasswordController@updateNewPassword')->name('resetNewPass')->middleware('guest');


Route::get('/home', 'postsController@postsIndex')->name('home');

Route::get('/posts/{filterType?}',        'postsController@postsIndex')->name('posts');
Route::post('/posts/search/',        'postsController@searchPosts')->name('search');
Route::get('/postDetails/{post_id}','postsController@postDetails')->name('postDetails');
Route::get('/posts/editPost/{post_id}','postsController@editPost')->name('editPost')->middleware(['auth','verified']);
Route::post('/posts/updatePost/','postsController@updatePost')->name('updatePost')->middleware(['auth','verified']);
Route::get('/posts/deletePost/{post_id}','postsController@deletePost')->name('deletePost')->middleware(['auth','verified']);
Route::get('/posts/disablePost/{post_id}','postsController@disablePost')->name('disablePost')->middleware(['auth','verified']);
Route::post('/posts/addComment/{post_id}','postsController@addComment')->name('addComment')->middleware(['auth','verified']);
Route::get('/posts/deleteComment/{comment_id}','postsController@deleteComment')->name('deleteComment')->middleware(['auth','verified']);
Route::post('/posts/replyComment/{comment_id}','postsController@replyComment')->name('replyComment')->middleware(['auth','verified']);
Route::get('/addPost',      'postsController@addPost')->name('addPost')->middleware(['auth','verified']);
Route::get('/profile/myPosts', 'postsController@myPostsIndex')->name('myPosts')->middleware(['auth','verified']);
Route::get('/profile/Edit', 'profileController@editMyProfile')->name('editMyProfile')->middleware(['auth','verified']);
Route::post('/profile/Update', 'profileController@UpdateMyProfile')->name('updateProfile')->middleware(['auth','verified']);
Route::post('/addPost',     'postsController@insertPost')->name('insertPost')->middleware(['auth','verified']);

Route::get('/notifications/{filterType?}', 'notificationController@notificationIndex')->name('notifications');



/*login social */
Route::get('/google/redirect', 'Auth\LoginController@googleRedirectToProvider')->name('googleRedirect');
Route::get('/google/callback', 'Auth\LoginController@googleHandleProviderCallback')->name('googleCallBack');

Route::get('/facebook/redirect', 'Auth\LoginController@facebookRedirectToProvider')->name('facebookRedirect');
Route::get('/facebook/callback', 'Auth\LoginController@facebookHandleProviderCallback')->name('facebookCallBack');



Route::group(['prefix' => 'admin'], function () {
    Route::get('/home',  function (){return redirect('admin/dashboard/');})->name('home')->middleware('admin');

    Route::get('/login',  'AdminAuth\LoginController@showLoginForm')->name('AdminLogin');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('AdmiLogout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('AdminRegister');
  Route::post('/register','AdminAuth\RegisterController@register');

  Route::post('/password/email','AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset','AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset','AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
//dashboard
    Route::get('/dashboard',  'admin\AdminController@indexDashboard')->name('dashboard')->middleware('admin');
    //users control
    Route::get('/users',  'admin\AdminController@usersIndex')->name('usersDashboard')->middleware('admin');
    Route::get('/users/userProfile/{user_id}',  'admin\AdminController@userProfile')->name('userProfile')->middleware('admin');
    Route::get('/users/control/{user_id}',  'admin\AdminController@controlUser')->name('controlUser')->middleware('admin');
    Route::get('/users/delete/{user_id}',  'admin\AdminController@deleteUser')->name('admin.deleteUser')->middleware('admin');
    //posts control
    Route::get('/posts',  'admin\AdminController@postsIndex')->name('postsDashboard')->middleware('admin');
    Route::post('/posts/search/',  'admin\AdminController@searchPosts')->name('admin.search')->middleware('admin');
    Route::get('/posts/postDetails/{post_id}',  'admin\AdminController@postDetails')->name('admin.postDetails')->middleware('admin');
    Route::get('/posts/control/{post_id}',  'admin\AdminController@controlPost')->name('controlPost')->middleware('admin');
    Route::get('/posts/reports/',  'admin\AdminController@allPostsReport')->name('allPostsReport')->middleware('admin');
    Route::get('/posts/delete/{post_id}',  'admin\AdminController@deletePost')->name('admin.deletePost')->middleware('admin');
    //comments control
    Route::get('/comments/delete/{comment_id}',  'admin\AdminController@deleteComment')->name('admin.deleteComment')->middleware('admin');
    Route::get('/replies/delete/{replay_id}',  'admin\AdminController@deleteReplay')->name('admin.deleteReplay')->middleware('admin');

});

