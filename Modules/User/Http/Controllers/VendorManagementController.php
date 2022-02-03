<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Vendor;
use Modules\Role\Entities\Role_user;
use Modules\Role\Entities\Role;
use Modules\User\Entities\VendorPayment;
use App\Models\User;
use Modules\Category\Entities\Category;
use Modules\Country\Entities\Country;
use File, Intervention\Image\Facades\Image;

class VendorManagementController extends Controller
{
    public function __construct(){
        $role = Role::where('slug','vendor')->first();
        $role_user = Role_user::where('role_id',$role->id)->pluck('user_id');
        $this->role_user = $role_user;
    }

    public function getApprovedVendors(){
        $users = User::whereIn('id',$this->role_user)->published()->approved()->ordered()->get();
        return view('user::vendors-list',compact('users'));
    }

    public function getSuspendedVendors(){
        $users = User::whereIn('id',$this->role_user)->published()->suspended()->ordered()->get();
        return view('user::vendors-list',compact('users'));
    }

    public function getNewVendors(){
        $users = User::whereIn('id',$this->role_user)->published()->new()->ordered()->get();
        return view('user::vendors-list',compact('users'));
    }

    public function getVendorProfile(Request $request, $username){
        $user = User::where('username',$username)->with('vendor')->first();
        $categories = Category::published()->select('id','name')->get();
        $countries = Country::published()->get();
        return view('user::profile',compact('user','categories','countries'));
    }

    public function getVendorProducts(Request $request, $username){
        $user = User::where('username',$username)->with('products')->first();
        return view('user::vendorproducts',compact('user'));
    }

    public function getReport(Request $request,$id){
        $paid = VendorPayment::where('user_id',$id)->get();
        return view('user::payment',compact('paid'));
    }

    public function updateVendorDetails(Request $request , $id){
        $request->validate([
            // 'shop_name' => 'required',
            // 'company_email' => 'required',
            // 'company_phone' => 'required',
            // 'product_category' => 'required',
            'image' => 'mimes:jpg,png,jpeg,gif|max:3048',
         ]);
        //  dd($id);
         $oldRecord = Vendor::where('user_id',$id)->first();
         $formInput = $request->except(['image']);
         if ($request->hasFile('image')) {
            if ($oldRecord->image) {
               $this->unlinkImage($oldRecord->image);
            }
            if ($request->image) {
               $image = $this->imageProcessing('img-', $request->file('image'));
               $formInput['image'] = $image;
            }
         }
         $formInput['business_type'] = $request->business_type;
         // dd($formInput);
        //  $r = json_encode($request->product_category);
        //  dd(json_encode($request->product_category), json_encode($request->cat));
         $oldRecord->update($formInput);
         return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
    }

    public function updateVendorDescription(Request $request, $id)
    {
       $request->validate([
          'description' => 'required',
       ]);
       $oldRecord = Vendor::where('user_id',$id)->first();
       $formInput = $request->except(['_token']);
       $oldRecord->update($formInput);
       return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
    }
 
    public function updateVendorBankDetails(Request $request, Vendor $vendor)
    {
       $request->validate([
          'bank_name' => 'nullable',
          'branch_name' => 'nullable',
          'account_number' => 'nullable',
          'name_on_bank_acc' => 'nullable',
          'bank_info_image' => 'mimes:jpg,png,jpeg,gif|max:3048',
       ]);
       $value = $request->except(['bank_info_image','token']);
       if ($request->hasFile('bank_info_image')) {
          if ($vendor->bank_info_image) {
             $this->unlinkImage($vendor->bank_info_image);
          }
          if ($request->bank_info_image) {
             $image = $this->imageProcessing('img-', $request->file('bank_info_image'));
             $value['bank_info_image'] = $image;
          }
       }
       
       $vendor->update($value);
       return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
    }
 
    public function updateUserDetails(Request $request, Vendor $vendor)
    {
       $request->validate([
          'name' => 'required',
          'phone_num' => 'required',
          'designation' => 'required',
       ]);
       $formInput = $request->except(['_token']);
       $vendor->user->update($formInput);
       return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
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
