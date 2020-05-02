<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**social login and register
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (User::whereEmail($request->email)->get()->first()->status != 'active') {
                $this->guard()->logout();
                $request->session()->flush();
                $request->session()->regenerate();
                return view('error', ['message' => 'accountBlocked']);
            }
            else{
                return redirect()->back();
            }
        }
        else {
            $this->incrementLoginAttempts($request);
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }
    }

    public function googleRedirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    public function ActiveWithPhone(Request $request){
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
    }
    public function facebookRedirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function googleHandleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            // log them in
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser                    = new User;
            $newUser->name              = $user->name;
            $newUser->email             = $user->email;
            $newUser->password          = Hash::make(12345678);
            $newUser->email_verified_at = now();

            /*$newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;*/
            $newUser->save();
            auth()->login($newUser, true);
        }
        return redirect()->to('/home');
    }
    public function facebookHandleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            // log them in
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->password          = Hash::make(12345678);
            $newUser->email_verified_at = now();

            /*$newUser->avatar_original = $user->avatar_original;*/
            $newUser->save();
            auth()->login($newUser, true);
        }
        return redirect()->to('/home');
    }


}
