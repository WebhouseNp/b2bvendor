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
use Modules\Payment\Entities\Transaction;

class VendorController extends Controller
{
   public function getVendorPaymentReport()
   {
      $id = Auth::user()->id;
      $user = auth()->user();
      $vendor = $user->load('vendor','products');
      // $vendor = User::where('id', Auth::user()->id)->with('vendor', 'products', 'vendor_payments')->first();
      $paid = $vendor->vendor_payments;
      return view('user::payment', compact('paid'));
   }
   public function profile()
   {
      $id = auth()->user()->id;
      $user = auth()->user();
      $vendor = $user->load('vendor','products');
      return view('user::vendor-profile', compact('id', 'vendor'));
   }

   public function editVendorProfile(Request $request, $id)
   {
      $user = auth()->user();
      $user->load('vendor');
      $countries = Country::where('publish', 1)->get();
      return view('user::edit-profile', compact('user', 'countries'));
   }

   public function updateVendorProfile(Request $request, $id)
   {
      $request->validate([
         'image' => 'mimes:jpg,png,jpeg,gif|max:3048',
      ]);
      $oldRecord = Vendor::where('id',auth()->user()->vendor->id)->first();

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

   public function updateVendorDesc(Request $request, Vendor $vendor)
   {
      $request->validate([
         'description' => 'required',
      ]);
      $vendor = Vendor::where('id',auth()->user()->vendor->id)->first();
      $formInput = $request->except(['_token']);
      $vendor->update($formInput);
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
      if($vendor->bank_name && $vendor->account_number && $vendor->branch_name && $vendor->name_on_bank_acc && $vendor->bank_info_image){
         return redirect()->back()->with('error', 'Please Contact Admin for updating Your Bank Details.');
      }
      $value = $request->except(['bank_info_image','token']);
      $vendor = Vendor::where('id',auth()->user()->vendor->id)->first();
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
      $vendor = Vendor::where('id',auth()->user()->vendor->id)->first();
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
      $due = Transaction::where('vendor_id', $vendor->vendor->id)->where('is_cod', '!=', true)->latest()->first()->running_balance ?? 0;
      return view('user::view', compact('id', 'vendor','due'));
   }
}
