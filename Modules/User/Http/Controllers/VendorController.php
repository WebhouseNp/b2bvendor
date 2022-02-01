<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Modules\Order\Entities\OrderList;
use Auth;
use Image, File;
use Modules\User\Entities\Vendor;
use Modules\Country\Entities\Country;

class VendorController extends Controller
{
   /**
    * Display a listing of the resource.
    * @return Renderable
    */
   public function getVendorPaymentReport()
   {
      $id = Auth::user()->id;
      $vendor = User::where('id', Auth::user()->id)->with('vendor', 'products', 'vendor_payments')->first();
      $paid = $vendor->vendor_payments;
      return view('user::payment', compact('paid'));
   }
   public function profile()
   {
      $id = Auth::user()->id;
      $vendor = User::where('id', Auth::user()->id)->with('vendor', 'products', 'vendor_payments')->first();
      // $order_list = OrderList::where('user_id',$vendor->id)->where('order_status','delivered')->sum('amount');
      // $paid = $vendor->vendor_payments->sum('amount');
      return view('user::vendor-profile', compact('id', 'vendor'));
   }

   public function editVendorProfile(Request $request, $id)
   {
      $user = User::where('id', Auth::user()->id)->with('vendor')->first();
      $countries = Country::where('publish', 1)->get();
      return view('user::edit-profile', compact('user', 'countries'));
   }

   public function updateVendorProfile(Request $request, $id)
   {
      $request->validate([
         'image' => 'mimes:jpg,png,jpeg,gif|max:3048',
      ]);
      $oldRecord = Vendor::findorfail($id);

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
      $oldRecord->update($formInput);
      return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
   }

   public function updateVendorDesc(Request $request, $id)
   {
      $request->validate([
         'description' => 'required',
      ]);
      $oldRecord = Vendor::findorfail($id);
      $formInput = $request->except(['_token']);
      $oldRecord->update($formInput);
      return redirect()->back()->with('success', 'Vendor Profile Updated Successfuly.');
   }

   public function updateVendorBankDetails(Request $request, Vendor $vendor)
   {
      $request->validate([
         'bank_name' => 'required',
         'branch_name' => 'required',
         'account_number' => 'required',
         'name_on_bank_acc' => 'required',
         'bank_info_image' => 'mimes:jpg,png,jpeg,gif|max:3048',
      ]);
      if($vendor->bank_name && $vendor->account_number && $vendor->branch_name && $vendor->name_on_bank_acc){
         return redirect()->back()->with('error', 'Please Contact Admin for updating Your Bank Details.');
      }
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
      $formInput = $request->except(['_token','email']);
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

   public function view($id)
   {
      $vendor = User::where('id', $id)->with('vendor', 'products', 'vendor_payments')->first();
      // $order_list = OrderList::where('user_id',$vendor->id)->where('order_status','delivered')->sum('amount');
      // $paid = $vendor->vendor_payments->sum('amount');
      return view('user::view', compact('id', 'vendor'));
   }
}
