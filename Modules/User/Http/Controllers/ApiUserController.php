<?php

namespace Modules\User\Http\Controllers;

use App\Mail\AccountActivated;
use App\Mail\PasswordReset;
use App\Mail\VendorCreated;
use App\Mail\VendorStatusChanged;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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

class ApiUserController extends Controller
{
  public function index()
  {
    $vendors = Vendor::all();
    return response(['vendors' => $vendors, 'message' => 'Retrieved successfully'], 200);
  }

  public function changeVendorStatus(Request $request)
  {
    $data = $request->all();
    $validation = Validator::make($data, [
      'vendor_id'      => 'required|numeric|exists:users,id',
      'vendor_type'          => 'required',
    ]);
    if ($validation->fails()) {
      foreach ($validation->messages()->getMessages() as $message) {
        $errors[] = $message;
      }
      return response()->json(['status' => false, 'message' => $errors]);
    }
    $user = User::find($request->vendor_id);
    if (!$user) {
      return response()->json(['status' => false, 'message' => ['Invalid vendor id or vendor not found.']]);
    }
    $user->update($data);
    $success = $user->save();
    Mail::to($user->email)->send(new VendorStatusChanged($user));
    return response()->json(['status' => true, 'message' => "Vendor updated Successfully.", 'data' => $user]);
  }

  public function updateVendor(Request $request, $id)
  {
    if (Vendor::where('id', $id)->exists()) {
      $vendor = Vendor::find($id);

      $formData = $request->all();
      $success = $vendor->update($formData);
      if ($success) {
        return response()->json([
          "message" => "vendors updated successfully"
        ], 200);
      } else {
        return response()->json([
          "message" => "Sorry Could not update vendor!!"
        ], 500);
      }
    } else {
      return response()->json([
        "message" => "Vendor not found"
      ], 400);
    }
  }



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

  public function register(Request $request)
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
        return response()->json(['status' => 'unsuccessful', 'status_code' => 422, 'data' => $validator->messages()], 422);
        exit;
      }
      $name = explode(' ', $request->name);
      $username = strtolower($name[0] . rand(10, 1000));
      $formData = $request->except(['password']);
      $data['publish'] = 1;
      $data['username'] = $username;
      $data['activation_link'] = Str::random(63);
      $data['otp'] =  random_int(100000, 999999);
      $data['name'] = $request->name;
      $data['designation'] = $request->designation;
      $data['gender'] = $request->gender;
      $data['email'] = $request->email;
      $data['phone_num'] = $request->phone_num;
      $data['password'] = bcrypt($request->password);
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
      // dd($request->product_category);
      // $formData['product_category'] = json_encode($request->product_category);
      // dd($formData);
      $formData['phone_number'] = $request->company_phone;
      // $formData['company_address'] = $request->company_address;
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

  public function VerifyNewAccount($link, Request $request)
  {
    try {
      $user = User::where(['activation_link' => $link])->first();
      if ($user->activation_link == $link) {
        $data['activation_link'] = null;
        $data['verified']     = 1;
      }
      if ($user->verified == 1) {
        return response()->json([
          "message" => "Thank You ! Your Account Has already been Activated. You can login your account",
        ], 200);
      }
      $user->fill($data);
      $success = $user->save();
      if ($success) {
        Mail::to($user->email)->send(new AccountActivated($user));
        return view('email-verified');
        // return redirect()->to('/vendor-login');
        return response()->json([
          "message" => "Thank You ! Your Account Has been Activated. You can login your account now",
        ], 200);
      }
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  public function verifificationCode(Request $request)
  {
    try {
      $user = User::where(['otp' => $request->otp])->first();
      if ($user->otp == $request->otp) {
        $data['otp'] = null;
        $data['verified']     = 1;
      }
      if ($user->verified == 1) {
        return response()->json([
          "message" => "Thank You ! Your Account Has already been Activated. You can login your account!!",
        ], 200);
      }
      $user->fill($data);
      $success = $user->save();
      if ($success) {
        Mail::to($user->email)->send(new AccountActivated($user));
        return response()->json([
          "message" => "Thank You ! Your Account Has been Activated. You can login your account now",
        ], 200);
      }
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }
  public function sendEmailLink(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
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
        $password = Password::where('email', $request->email)->where('token', $token)->first();
        //sending email link
        $data = ['email' => $request->email, 'token' => $token];
        Mail::to($data['email'])->send(new PasswordReset($password));
        return response()->json([
          "message" => "Email has been sent to your email",
        ], 200);
      }
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  //password reset
  public function resetPassword(Request $request)
  {
    $token = $request->token;
    if (!$passwordRests = DB::table('password_resets')->where('token', $token)->first()) {
      return response([
        'message' => 'Invalid Token!'
      ], 400);
    }

    if (!$user = User::where('email', $passwordRests->email)->first()) {
      return response([
        'message' => 'User doesn\'t exist!'
      ], 404);
    }

    $user->password = bcrypt($request->password);
    $user->save();
    return response([
      'message' => "Password reset!"
    ], 200);
  }

  public function changePassword(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'new_confirm_password' => 'required|min:6|same:new_password',

      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
        exit;
      }
      if (Hash::check($request->old_password, auth()->user()->password)) {

        $user = User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        return response()->json([
          "message" => "Password has been changed",
        ], 200);
      }
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  public function createdue(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'remarks' => 'required',
      'image' => 'mimes:jpg,jpeg,png',
    ]);

    if ($validator->fails()) {
      return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
      exit;
    }

    $value = $request->except('image');
    if ($request->image) {
      $image = $this->imageProcessing('img-', $request->file('image'));
      $value['image'] = $image;
    }

    DB::beginTransaction();
    $data = VendorPayment::create($value);
    DB::commit();
    return response()->json(['status' => 'successful', 'message' => 'Payment done successfully.', 'data' => $data]);
  }

  public function imageProcessing($type, $image)
  {
    $input['imagename'] = $type . time() . '.' . $image->getClientOriginalExtension();
    $thumbPath = public_path('images/thumbnail');
    $mainPath = public_path('images/main');
    $listingPath = public_path('images/listing');

    $img1 = Image::make($image->getRealPath());
    $img1->fit(530, 300)->save($thumbPath . '/' . $input['imagename']);


    $img2 = Image::make($image->getRealPath());
    $img2->fit(99, 88)->save($listingPath . '/' . $input['imagename']);

    $destinationPath = public_path('/images');
    return $input['imagename'];
  }
}
