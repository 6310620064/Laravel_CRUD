<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Social;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $input = $request->all();

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt(array('email' => $input['email'],'password'=> $input['password']))) {
            if (auth()->user()->is_admin ==1) {
                return redirect()->route('admin.home');
            } else{
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login')->with('error','Email-address and Password are Wrong.');
        }
    }

    //Google Login
    public function redirectToGoogle() 
    {
        return Socialite::driver('google')->redirect();
    }
    
    //Google Callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $registeredUser = $this->_registerOrLoginUser($user,'google');

        if (!$registeredUser->isUser) {
            return redirect()->route('newPasswordGet')->with('email', $registeredUser->email);
        }

        else {
            return redirect('/');
        }
    }

     //Github Login
     public function redirectToGithub() 
     {
         return Socialite::driver('github')->redirect();
     }
     
     //Github Callback
     public function handleGithubCallback()
     {
        $user = Socialite::driver('github')->user();

        $registeredUser = $this->_registerOrLoginUser($user,'github');

        if (!$registeredUser->isUser) {
             return redirect()->route('newPasswordGet')->with('email', $registeredUser->email);
        }
 
        else {
            return redirect('/');
        }
     }

     // Line Login
    public function redirectToLine()
    {
        return Socialite::driver('line')->redirect();
    }

    public function handleLineCallback()
    {
        $user = Socialite::driver('line')->user();

        $registeredUser = $this->_registerOrLoginUser($user,'line');

        if (!$registeredUser->isUser) {
            return redirect()->route('newPasswordGet')->with('email', $registeredUser->email);
        }

        else {
            return redirect('/');
        }
    }

 
    protected function _registerOrLoginUser($data,$provider)
    {
        $user = User::where('email','=',$data->email)->first();
        $isUser = true;
        
        if (!$user) {
            $user = new User();
            $user->name = $data->name ?? $data->nickname;
            $user->email = $data->email;
            $user->save();
    
            $social = new Social();
            $social->name = $user->name;
            $social->email= $user->email;
            $social->provider = $provider;
            $social->provider_id = $data->id;
            $social->save();
            Auth::login($user);
            $isUser = false;
        }
        else {
            $social = Social::where('email', $user->email)->where('provider', $provider)->first();
            if (!$social) {
                $social = new Social();
                $social->name = $user->name;
                $social->email = $user->email;
                $social->provider = $provider;
                $social->provider_id = $data->id;
                $social->save();
            }
            else{
                if ($isUser = false){
                    return redirect()->route('newPasswordGet')->with('email', $registeredUser->email);
                }
            }
            Auth::login($user);
        }
        return (object) [
            'email' => $user->email,
            'isUser' => $isUser,
        ];
    }
}
