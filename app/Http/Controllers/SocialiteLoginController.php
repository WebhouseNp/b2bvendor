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
        $url = Socialite::with(static::GOOGLE_TYPE)->redirect()->getTargetUrl();
        return response()->json([
            "url"=>$url
        ]);
    }

    public function handleGoogleCallBack(){
        try{
            $user = Socialite::driver(static::GOOGLE_TYPE)->stateless()->user();

            $userExisted = User::where('oauth_id',$user->id)->where('oauth_type',static::GOOGLE_TYPE)->first();

            if($userExisted){

                Auth::login($userExisted);
                $token = auth()->user()->createToken('authToken')->accessToken;
                return response()->json([
                    "status" => "true",
                    "message" => "success",
                    'token' => $token,
                    'user' => auth()->user()
                  ], 200);

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
                $token = auth()->user()->createToken('authToken')->accessToken;
                return response()->json([
                    "status" => "true",
                    "message" => "success",
                    'token' => $token,
                    'user' => auth()->user()
                  ], 200);
            }
        }catch(Exception $e){
            dd($e);
        }
    }

    //Facebook login

    CONST FACEBOOK_TYPE = 'facebook';

    public function redirectToFacebook(){
        $url = Socialite::with(static::FACEBOOK_TYPE)->redirect()->getTargetUrl();
       return response()->json([
        "url"=>$url
    ]);
    }

    public function handleFacebookCallBack(){
        try{
            $user = Socialite::driver(static::FACEBOOK_TYPE)->stateless()->user();

            $userExisted = User::where('oauth_id',$user->id)->where('oauth_type',static::FACEBOOK_TYPE)->first();

            if($userExisted){

                Auth::login($userExisted);
                $token = auth()->user()->createToken('authToken')->accessToken;
                return response()->json([
                    "status" => "true",
                    "message" => "success",
                    'token' => $token,
                    'user' => auth()->user()
                  ], 200);

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
                $token = auth()->user()->createToken('authToken')->accessToken;
                return response()->json([
                    "status" => "true",
                    "message" => "success",
                    'token' => $token,
                    'user' => auth()->user()
                  ], 200);
            }
        }catch(Exception $e){
            dd($e);
        }
    }
}
