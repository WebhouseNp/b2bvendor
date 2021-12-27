<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use App\Models\User;
use App\Password;
use Modules\User\Entities\Vendor;
use Modules\Role\Entities\Role_user;
use Modules\Role\Entities\Role;
use Modules\User\Entities\Profile;
use Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Str;
use Mail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    public function register(Request $request){
        DB::beginTransaction();
          try{
              $validator = Validator::make($request->all(), [
              'full_name' => 'required|string',
              'phone_num' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7',
              'email' => 'required|email|unique:users',
              'password' => 'required',
              'confirm_password' => 'required|min:6|same:password',
            //   'terms_condition' => 'required',
           ]);
          
          if($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()],422);
            exit;
        }
          $name = explode(' ', $request->full_name);
          $username = strtolower($name[0] . rand(10, 1000));
          $formData = $request->except(['password']);
          $data['publish'] = 1;
          $data['username'] = $username;
          $data['activation_link'] = Str::random(63);
          $data['otp'] =  random_int(100000, 999999);
  
          $data['name'] = $request->full_name;
          $data['email'] = $request->email;
          $data['phone_num'] = $request->phone_num;
          $data['password'] = bcrypt($request->password);
          $userExist = User::create($data);
          
          if ($userExist){
            $user = User::where('email', $request->email)->first();
          }
          
          $formData['user_id'] = $user->id;
          $profile_data = [
            'user_id'=> $formData['user_id'],
            'full_name' => $formData['full_name'],
            'mobile_num' => $formData['phone_num'],
            'email' => $formData['email'],
          ];
          $profile = Profile::create($profile_data);
          $role_data = [
            'role_id' => 4,
            'user_id' => $formData['user_id']
          ];
          $formData = $request->except('activation_link', 'terms_condition',  '_token');
          $formData['user_id'] = $user->id;
          $role_user = Role_user::create($role_data);
        //   dd($formData);
          DB::commit();
          $mail_data = [
            'name' => $formData['full_name'],
            'password' => $request->password,
            'email' => $request->email,
            'link' => route('user.verifyNewAccount', $data['activation_link']),
            'otp' => $data['otp'] ,
         ];
         Mail::send('email.account-activation-mail', $mail_data, function ($message) use ($mail_data, $request) {
            $message->to($request->email)->from(env('MAIL_FROM_ADDRESS'));
            $message->subject('Account activation link');
         });
          return response()->json([
            "message" => "success",
            'vendor' => $userExist
          ],200);
  
      } catch(\Exception $exception){
        DB::rollback();
          return response([
              'message' => $exception->getMessage()
          ],400);
      }
         
      } 

      public function VerifyNewAccount($token, Request $request)
    {
            try{
              $user = User::where(['activation_link' => $token])->first();
              if ($user->activation_link == $token) {
                $data['activation_link'] = null;
                $data['verified']     = 1;
            }
            $user_info = [
              'email' => $user->email,
              'name' => $user->name,
          ];

          $user->fill($data);
        //   dd($data);
          $success = $user->save();
          if ($success) {
            $mail_data = [
              'name' => $user->name,
              'email' => $user->email,
           ];

            Mail::send('email.account-activation-mail-reply', $mail_data, function ($message) use ($mail_data, $request, $user) {
              $message->to($user->email)->from(env('MAIL_FROM_ADDRESS'));
              $message->subject('Account Activated Email');
           });

           return response()->json([
            "message" => "Thank You ! Your Account Has been Activated. You can login your account now",
          ],200);

        } 
            } catch(\Exception $exception){
                return response([
                    'message' => $exception->getMessage()
                ],400);
            }
            
    }

    public function verifificationCode(Request $request){
        try{
          $user = User::where(['otp' => $request->otp])->first();
          if ($user->otp == $request->otp) {
            $data['otp'] = null;
            $data['verified']  = 1;
        }
        $user_info = [
          'email' => $user->email,
          'name' => $user->name,
      ];
  
      $user->fill($data);
      $success = $user->save();
      if ($success) {
        $mail_data = [
          'name' => $user->name,
          'email' => $user->email,
       ];
  
        Mail::send('email.account-activation-mail-reply', $mail_data, function ($message) use ($mail_data, $request, $user) {
          $message->to($user->email)->from(env('MAIL_FROM_ADDRESS'));
          $message->subject('Account Activated Email');
       });
       return response()->json([
        "message" => "Thank You ! Your Account Has been Activated. You can login your account now",
      ],200);
  
    } 
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
        
      }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        try{
            $user = User::where('email', $request->email)->with('roles')->firstOrFail();
         
            if (!\Hash::check($request->password, $user->password)) {
              return response()->json([
                "message" => "Invalid Password!!"
              ],401);
           }

           $roles = [];
           foreach($user->roles as $role){
               $slug = $role->slug;
               array_push($roles,$slug);
           }

           if (in_array('customer' ,$roles) && $user->publish == '0') {
              return response()->json([
                "status" => "false",
                "message" => "Please contact admin!!"
              ],401);
           }
            
            if(in_array('customer' ,$roles)){
                if (Auth::attempt([
                  'email' => $request['email'],
                  'password' => $request['password'],
              ])) {
                  $user = User::where('email', $request->email)->first();
                    $token = auth()->user()->createToken('authToken')->accessToken;
                  if ($user->verified == 0) {
                    session()->flush();
                    return response()->json([
                      "status" => "false",
                      "message" => "Please Verify your account first!!"
                    ],401);
                  }
                 return response()->json([
                  "status" => "true",
                     "message" => "success",
                     'token' => $token,
                     'user' => $user
                   ],200);
         
                 }
            } else {
                return response()->json([
                  "status" => "false",
                    "message" => "You are not authorized.",
                  ],401);
            }

            
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],500);
        }
    }

    public function sendEmailLink(Request $request)
    {
        try{
          $validator = Validator::make($request->all(), [
            'email' => 'required',
         ]);
        
        if($validator->fails()) {
          return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
          exit;
      }
          $details = User::where('email', $request->email)->first();
        if ($details) {
            $randomNumber = Str::random(10);

            $token_withSlash = bcrypt($randomNumber);

            $token = str_replace('/', '', $token_withSlash);
            // saving token and user name
            $savedata = ['email' => $request->email, 'token' => $token, 'created_at' => \Carbon\Carbon::now()->toDateTimeString()];
            Password::insert($savedata);
            //sending email link
            $data = ['email' => $request->email, 'token' => $token];
            Mail::send('email.password-reset', $data, function ($message) use ($data) {
              $message->to($data['email'])->from(env('MAIL_FROM_ADDRESS'));
              $message->subject('password reset link');
           });
           return response()->json([
            "message" => "Email has been sent to your email",
          ],200);

        } 
      } catch(\Exception $exception){
        return response([
            'message' => $exception->getMessage()
        ],400);
    }
    }

    public function updatePassword(Request $request)
    {
      try{
        $validator = Validator::make($request->all(), [
        //   'email' => 'required',
          'password' => 'required|min:6',
          'confirm_password' => 'required|min:6|same:password',
 
       ]);
      
      if($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
        exit;
    }
        $details = Password::where('token', $request->token)->first();
        $user = User::where('email',$details->email)->first();
        $value = $request->all();
        if ($request->password) {
            $value['password'] = bcrypt($request->password);
        }
        $user->update($value);
        return response()->json([
          "message" => "Password has been changed",
        ],200);

      }  catch(\Exception $exception){
        return response([
            'message' => $exception->getMessage()
        ],400);
    }
    }


    public function changePassword(Request $request)
    {
      // dd(auth()->user());
        try{
          $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'new_confirm_password' => 'required|min:6|same:new_password',
   
         ]);
        
        if($validator->fails()) {
          return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
          exit;
      }
      $auth_user = User::find(auth()->user()->id);
        if (Hash::check($request->old_password, auth()->user()->password)) {

            $user = $auth_user->update(['password' => Hash::make($request->new_password)]);
            return response()->json([
              "message" => "Password has been changed",
            ],200);
        }
       } catch(\Exception $exception){
          return response([
              'message' => $exception->getMessage()
          ],400);
      }
        
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    public function vendors()
    {
        return 'hi';
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
