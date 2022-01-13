<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Modules\Order\Entities\OrderList;
use Auth;
use Image;
use Modules\User\Entities\Vendor;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
   public function getVendorPaymentReport(){
      $id = Auth::user()->id;
      $vendor = User::where('id',Auth::user()->id)->with('vendor','products','vendor_payments')->first();
      $paid = $vendor->vendor_payments;
      return view('user::payment',compact('paid'));
   }
     public function profile(){
         $id = Auth::user()->id;
         $vendor = User::where('id',Auth::user()->id)->with('vendor','products','vendor_payments')->first();
         $order_list = OrderList::where('user_id',$vendor->id)->where('order_status','delivered')->sum('amount');
         $paid = $vendor->vendor_payments->sum('amount');
        return view('user::vendor-profile', compact('id','vendor','order_list','paid'));
     }

     public function editVendorProfile(Request $request, $id){
        $user = User::where('id',Auth::user()->id)->with('vendor')->first();
        return view('user::edit-profile',compact('user'));
      }

      public function updateVendorProfile(Request $request, $id){
          $request->validate([
            'image' => 'mimes:jpg,png,jpeg,gif|max:3048',
         ]);
         $oldRecord = Vendor::findorfail($id);
   
         $formInput = $request->except(['image']);
         if ($request->hasFile('image')) {
            if ($oldRecord->image) {
               $this->unlinkImage($oldRecord->image);
            }
            $formInput['image'] = $this->imageProcessing($request->image, 1287, 550, 'no');
         }
         $oldRecord->update($formInput);
         return redirect()->route('vendor.profile')->with('success', 'Vendor Profile Updated Successfuly.');

      }

      public function updateVendorDesc(Request $request, $id){
         $request->validate([
           'description' => 'nullable',
        ]);
        $oldRecord = Vendor::findorfail($id);
        $formInput = $request->except(['_token']);
        $oldRecord->update($formInput);
        return redirect()->route('vendor.profile')->with('success', 'Vendor Profile Updated Successfuly.');

     }

      public function imageProcessing($image)
      {
        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
        $thumbPath = public_path('images/thumbnail');
        $mainPath = public_path('images/main');
        $listingPath = public_path('images/listing');
    
        $img1 = Image::make($image->getRealPath());
        $img1->save($mainPath . '/' . $input['imagename']);
        $img2 = Image::make($image->getRealPath());
        $img2->save($listingPath . '/' . $input['imagename']);
        $img1 = Image::make($image->getRealPath());
        $img1->fit(90, 100)->save($thumbPath . '/' . $input['imagename']);
    
        $destinationPath = public_path('/images');
        return $input['imagename'];
      }

   public function unlinkImage($imagename)
   {
      $thumbPath = public_path('images/thumbnail/') . $imagename;
      $mainPath = public_path('images/main/') . $imagename;
      $listingPath = public_path('images/listing/') . $imagename;
      if (file_exists($thumbPath))
         unlink($thumbPath);
      if (file_exists($mainPath))
         unlink($mainPath);
      if (file_exists($listingPath))
         unlink($listingPath);
      return;
   }


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
