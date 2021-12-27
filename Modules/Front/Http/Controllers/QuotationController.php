<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Front\Entities\Quotation;
use Validator, DB, File;
use Image;
use Illuminate\Support\Facades\Mail;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $quotations = Quotation::orderBy('created_at','Desc')->get();
        return view('front::index',compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('front::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'first_name'             => 'required|string',
                'last_name'             => 'required|string',
                'email'             => 'required|email',
                'purchase'             => 'required|string',
                'quantity'          => 'required|numeric',
                'contact_num'              => 'required',
                'mobile_num'       => 'required',
                'ship_to'        => 'nullable',
                'expected_price'  => 'nullable',
                'expected_del_time'           => 'nullable',
                'other_contact'    => 'nullable',
                "link"    => "required|link",
                "specifications"  => "nullable",
                'image1' =>  'nullable|mimes:jpg,jpeg,png|max:3000',
                'image2' =>  'nullable|mimes:jpg,jpeg,png|max:3000',
                'image3' =>  'nullable|mimes:jpg,jpeg,png|max:3000',

            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()],422);
                exit;
            }

            $value = $request->except('image1','image2','image3');

            if ($request->image1) {
                $image = $this->imageProcessing('img-', $request->file('image1'));
                $value['image1'] = $image;
            }
            if ($request->image2) {
                $image = $this->imageProcessing('img-', $request->file('image2'));
                $value['image2'] = $image;
            }
            if ($request->image3) {
                $image = $this->imageProcessing('img-', $request->file('image3'));
                $value['image3'] = $image;
            }
            $data = Quotation::create($value);
            $quotation_info = [
                'name' => $request->first_name,
                'email' => $request->email,
                'purchase' =>$request->purchase,
                'quantity' => $request->quantity,
                'contact_num'              => $request->contact_num,
                'mobile_num'       => $request->mobile_num,
                'ship_to'        => $request->ship_to,
                'expected_price'  => $request->expected_price,
                'expected_del_time'           => $request->expected_del_time,
                'other_contact'    => $request->other_contact,
                "link"    => $request->link,
                "specifications" => $request->specifications
            ];
                Mail::send('email.quotation',$quotation_info,  function ($message) use ($request){
                    $message->to('info@sastowholesale.com','Admin')
    
                        ->subject('Quotation Received' );
                    $message->from($request->email, $request->first_name);
                });
            return response()->json(['status' => 'successful', 'message' => 'Quotation Submitted successfully.', 'data' => $data]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
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

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('front::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('front::edit');
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
