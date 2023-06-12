<?php

namespace App\Http\Controllers\Auth;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
   public function redirect($provider)
   {
        return Socialite::driver($provider)->redirect();
   }

   public function callback($provider)
   {   
        try{
            $Socialuser = Socialite::driver($provider)->user();
            if(User::where('email', $Socialuser->getEmail())->exists()){
                return redirect('/login')->withErrors(['email' => 'This email uses different method to login']);
            }
            $user = User::where([
                'provider' => $provider,
                'provider_id' => $Socialuser->id
            ])->first();
            if(!$user){
                $user = User::create([
                    'name' => $Socialuser->getName(),
                    'email'=> $Socialuser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $Socialuser->getId(),
                    'provider_token' => $Socialuser ->token,
                    'email_verified_at' => now()
                ]);
            }
            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e){
            return redirect('/login');
        }     
   }
}
