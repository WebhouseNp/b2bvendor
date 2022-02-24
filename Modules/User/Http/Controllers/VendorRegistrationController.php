<?php

namespace Modules\User\Http\Controllers;

use App\Http\Requests\VendorRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Mail\AccountActivated;
use App\Mail\PasswordReset;
use App\Mail\VendorCreated;
use App\Mail\VendorStatusChanged;
use Auth;
use App\Models\User;
use App\Password;
use Modules\User\Entities\Vendor;
use Modules\Role\Entities\Role_user;
use Modules\Role\Entities\Role;
use Modules\Product\Entities\Product;
use Modules\Order\Entities\OrderList;
use Modules\User\Entities\VendorPayment;
use Image;
use Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use Str;
use Mail;
use Illuminate\Support\Facades\Hash;

class VendorRegistrationController extends Controller
{
    public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');
    try {
      $user = User::where('email', $request->email)->with('roles')->first();
      if (!$user) {
        return response()->json([
          "message" => "User Not Found!!"
        ], 401);
      }
      $roles = [];
      foreach ($user->roles as $role) {
        $slug = $role->slug;
        array_push($roles, $slug);
      }
      if (!\Hash::check($request->password, $user->password)) {
        return response()->json([
          "message" => "Invalid Password!!"
        ], 401);
      }
      if (in_array('vendor', $roles) && $user->publish == '0') {
        return response()->json([
          "message" => "Please contact admin!!"
        ], 401);
      }

      if (in_array('vendor', $roles)) {
        if (Auth::attempt([
          'email' => $request['email'],
          'password' => $request['password'],
        ])) {
          $user = User::where('email', $request->email)->first();
          $token = auth()->user()->createToken('authToken')->accessToken;
          $user->api_token = $token;
          $user->save();

          if ($user->verified == 0) {
            session()->flush();
            return response()->json([
              "status_code" => 401,
              "message" => "Please Verify your account first!!"
            ], 401);
          }
          if ($user->vendor_type == 'new' || $user->vendor_type == 'suspended') {
            session()->flush();
            return response()->json([
              "status_code" => 401,
              "message" => "Please Verify your account by admin first!!"
            ], 400);
          }
          return response()->json([
            "status_code" => 200,
            "message" => "success",
            'token' => $token,
            'user' => $user
          ], 200);
        }
      } else {
        return response()->json([
          "status_code" => 401,
          "message" => "You are not authorized.",
        ], 401);
      }
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }


    return response()->json([
      "message" => "Invalid Username/password"
    ], 500);
  }

    public function register(VendorRequest $request)
  {
    DB::beginTransaction();
    try {
      $validator = Validator::make($request->all(), [
        'email' => 'required|email|unique:users',
        'name' => 'required',
        'password' => 'required|min:6',
        'confirm_password' => 'required_with:password|same:password'

      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
        exit;
      }
      $name = explode(' ', $request->name);
      $username = strtolower($name[0] . rand(10, 1000));
      $data = [
        'publish' => 1,
        'username' => $username,
        'activation_link' => Str::random(63),
        'otp' =>    random_int(100000, 999999),
        'name' => $request->name,
        'email' => $request->email,
        'designation' => $request->designation,
        'gender' => $request->gender,
        'phone_num' => $request->phone_num,
        'password' => bcrypt($request->password)
         ];
      $userExist = User::create($data);

      if ($userExist) {
        $user = User::where('email', $request->email)->first();
      }

      $formData['user_id'] = $user->id;
      $formData['country_id'] = $request->country_id;
      $role = Role::where('name', 'vendor')->first();
      $role_data = [
        'role_id' => $role->id,
        'user_id' => $formData['user_id']
      ];
      $formData = $request->except('activation_link', 'terms_condition',  '_token');
      $formData['user_id'] = $user->id;
      $role_user = Role_user::create($role_data);
      $formData['phone_number'] = $request->company_phone;
      $vendor = Vendor::create($formData);
      $vendor->categories()->sync($request->category_id);
      DB::commit();
      Mail::to($request->email)->send(new VendorCreated($vendor));
      return response()->json([
        "status_code" => 200,
        "message" => "success",
        'vendor' => $vendor
      ], 200);
    } catch (\Exception $exception) {
      DB::rollback();
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }
}
