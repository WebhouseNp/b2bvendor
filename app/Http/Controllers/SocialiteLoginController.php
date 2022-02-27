<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Modules\Role\Entities\Role_user;

class SocialiteLoginController extends Controller
{
    //Google Login
    CONST GOOGLE_TYPE = 'google';

    public function redirectToGoogle(){
        return Socialite::driver(static::GOOGLE_TYPE)->redirect();
    }

    public function handleGoogleCallBack(){
        try{
            $user = Socialite::driver(static::GOOGLE_TYPE)->user();

            $userExisted = User::where('oauth_id',$user->id)->where('oauth_type',static::GOOGLE_TYPE)->first();

            if($userExisted){

                Auth::login($userExisted);

                return redirect()->back();

            }else{

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => static::GOOGLE_TYPE,
                    'password' => Hash::make($user->id),
                    'avatar' => $user->avatar,
                    'publish' => 1,
                    'verified' => 1,
                    'vendor_type' => 'approved'
                ]);

                if($newUser){
                    $customer = User::where('email', $user->email)->first();
                }

                $role_data = [
                    'role_id' => 4,
                    'user_id' => $customer->id
                ];
                Role_user::create($role_data);

                Auth::login($newUser);

                return redirect()->back();
            }
        }catch(Exception $e){
            dd($e);
        }
    }

    //Facebook login

    CONST FACEBOOK_TYPE = 'facebook';

    public function redirectToFacebook(){
       return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallBack(){
        try{
            $user = Socialite::driver(static::FACEBOOK_TYPE)->user();

            $userExisted = User::where('oauth_id',$user->id)->where('oauth_type',static::FACEBOOK_TYPE)->first();

            if($userExisted){

                Auth::login($userExisted);

                return redirect()->back();

            }else{

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => static::FACEBOOK_TYPE,
                    'password' => Hash::make($user->id),
                    'avatar' => $user->avatar,
                    'publish' => 1,
                    'verified' => 1,
                    'vendor_type' => 'approved'
                ]);

                if($newUser){
                    $customer = User::where('email', $user->email)->first();
                }

                $role_data = [
                    'role_id' => 4,
                    'user_id' => $customer->id
                ];
                Role_user::create($role_data);

                Auth::login($newUser);

                return redirect('http://localhost:8080');
            }
        }catch(Exception $e){
            dd($e);
        }
    }
}
