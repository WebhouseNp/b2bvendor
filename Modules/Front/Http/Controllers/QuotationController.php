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
        $quotations = Quotation::orderBy('created_at', 'Desc')->get();
        return view('front::index', compact('quotations'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'purchase'      => 'required|string',
            'quantity'      => 'required|numeric',
            'unit'      => 'required',
            "specifications"  => "required",
            'image1' =>  'nullable|mimes:jpg,jpeg,png|max:3000',
            'image2' =>  'nullable|mimes:jpg,jpeg,png|max:3000',
            'image3' =>  'nullable|mimes:jpg,jpeg,png|max:3000',
            'name'    => 'required|string',
            'email'         => 'required|email',
            'mobile_num'    => 'required',
            'ship_to'       => 'required',
            'expected_price'  => 'required',
            'expected_del_time' => 'required',
            'other_contact' => 'required',
            "link"  => "required",
        ]);

        try {
            $quotation = new Quotation([
                'purchase' => $request->purchase,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                "specifications" => $request->specifications,
                'image1' => $request->hasFile('image1') ? $request->file('image1')->store('uploads/quotations') : null,
                'image2' => $request->hasFile('image2') ? $request->file('image2')->store('uploads/quotations') : null,
                'image3' => $request->hasFile('image3') ? $request->file('image3')->store('uploads/quotations') : null,
                'name' => $request->first_name,
                'email' => $request->email,
                'mobile_num'    => $request->mobile_num,
                'ship_to'       => $request->ship_to,
                'expected_price'  => $request->expected_price,
                'expected_del_time' => $request->expected_del_time,
                'other_contact' => $request->other_contact,
                "link"  => $request->link,
            ]);

            $quotation->save();

            // Mail::send('email.quotation', $quotation,  function ($message) use ($request) {
            //     $message->to('info@sastowholesale.com', 'Admin')
            //         ->subject('Quotation Received');
            //     $message->from($request->email, $request->first_name);
            // });

            return response()->json(['status' => 'successful', 'message' => 'Quotation Submitted successfully.', 'data' => $quotation]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
