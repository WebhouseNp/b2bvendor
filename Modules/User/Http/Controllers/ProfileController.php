<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Profile;
use Modules\User\Entities\Address;
use Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Front\Transformers\CustomerResource;
use DB;
use App\Models\User;

class ProfileController extends Controller
{
  public function index()
  {
    return view('user::index');
  }

  public function getAddress()
    {
        return response()->json([
            'data' => auth()->user()->address
        ], 200);
    }

  public function editAddress(Request $request, User $user)
  {
    try {
      $validator = Validator::make($request->all(), [
        'full_name' => 'sometimes',
        'email' => 'sometimes|email',
        'phone' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|min:7',
        'country' => "sometimes",
        'city' => 'sometimes',
        'street_address' => 'sometimes',
        'nearest_landmark' => "sometimes",
        'company_name' => "sometimes",
        'vat' => "sometimes",
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
        exit;
      }
      // save the address
      $address = [
        'full_name' => $request->full_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'country' => $request->country,
        'city' => $request->city,
        'street_address' => $request->street_address,
        'nearest_landmark' => $request->nearest_landmark,
        'company_name' => $request->company_name,
        'vat' => $request->vat,
      ];
      $user->address()->updateOrCreate([
          'type' => null
        ], $address);

      return response()->json([
        "message" => "Address Updated Successfully!!",
      ], 200);
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  public function edit(User $user)
  {
    return CustomerResource::make($user);
  }

  public function update(Request $request, User $user)
  {
    try {
      $validator = Validator::make($request->all(), [
        'full_name' => 'nullable',
        'email' => 'nullable',
        'birthday' => 'nullable|',
        'gender' => 'sometimes',
        'phone_num' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:7',

      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
        exit;
      }
      $formInput = $request->except('publish', 'image');
      $formInput['publish'] = 1;
      // if ($request->hasFile('image')) {
      //   if ($user->image) {
      //     $this->unlinkImage($user->image);
      //   }
      //   if ($request->image) {
      //     $image = $this->imageProcessing('img-', $request->file('image'));
      //     $formInput['image'] = $image;
      //   }
      // }
      $user->update($formInput);

      return response()->json([
        "message" => "User Profile updated Successfully!!",
        "data" => $user
      ], 200);
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }

  public function updateImage(Request $request, User $user){
    try {
      $validator = Validator::make($request->all(), [
        'image' => 'mimes:jpg,png,jpeg,gif|max:3048',
      ]);

      if ($validator->fails()) {
        return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
        exit;
      }
      if ($request->hasFile('image')) {
        if ($user->image) {
          $this->unlinkImage($user->image);
        }
        if ($request->image) {
          $image = $this->imageProcessing('img-', $request->file('image'));
          $user['image'] = $image;
        }
      }
      $user->update($formInput);
      return response()->json([
        "message" => "User Profile updated Successfully!!",
        "data" => $user
      ], 200);
    } catch (\Exception $exception) {
      return response([
        'message' => $exception->getMessage()
      ], 400);
    }
  }
  
  public function profileImage(User $user)
  {
    return CustomerResource::make($user);
  }

  public function imageProcessing($type, $image)
  {
    $input['imagename'] = $type . time() . '.' . $image->getClientOriginalExtension();
    $thumbPath = public_path() . "/images/thumbnail";
    if (!File::exists($thumbPath)) {
      File::makeDirectory($thumbPath, 0777, true, true);
    }
    $listingPath = public_path() . "/images/listing";
    if (!File::exists($listingPath)) {
      File::makeDirectory($listingPath, 0777, true, true);
    }
    $img1 = Image::make($image->getRealPath());
    $img1->fit(99, 88)->save($thumbPath . '/' . $input['imagename']);


    $img2 = Image::make($image->getRealPath());
    $img2->save($listingPath . '/' . $input['imagename']);

    return $input['imagename'];
  }

  public function unlinkImage($imagename)
  {
    $thumbPath = public_path('images/thumbnail/') . $imagename;
    $listingPath = public_path('images/listing/') . $imagename;
    if (file_exists($thumbPath))
      unlink($thumbPath);
    if (file_exists($listingPath))
      unlink($listingPath);
    return;
  }
}
