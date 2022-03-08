<?php

namespace Modules\Quotation\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Quotation\Entities\Quotation;
use Modules\User\Entities\Vendor;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $quotations = Quotation::when(auth()->user()->hasRole('vendor'), function ($query) {
            $query->whereHas('vendors', function ($query) {
                $query->where('vendor_id', auth()->user()->vendor->id);
            });
        })->latest()->get();

        return view('quotation::index', compact('quotations'));
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
            'category_id'      => 'required',
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
            'expected_price'  => 'nullable',
            'expected_del_time' => 'nullable',
            'other_contact' => 'nullable',
            "link"  => "nullable",
        ]);

        try {
            DB::beginTransaction();
            $quotation = new Quotation([
                'purchase' => $request->purchase,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                "specifications" => $request->specifications,
                'image1' => $request->hasFile('image1') ? $request->file('image1')->store('uploads/quotations') : null,
                'image2' => $request->hasFile('image2') ? $request->file('image2')->store('uploads/quotations') : null,
                'image3' => $request->hasFile('image3') ? $request->file('image3')->store('uploads/quotations') : null,
                'name' => $request->name,
                'email' => $request->email,
                'mobile_num'    => $request->mobile_num,
                'ship_to'       => $request->ship_to,
                'expected_price'  => $request->expected_price,
                'expected_del_time' => $request->expected_del_time,
                'other_contact' => $request->other_contact,
                "link"  => $request->link,
            ]);

            $quotation->save();

            $vendors = Vendor::with('user')->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->category_id);
            })->get();

            foreach ($vendors as $vendor) {
                DB::table('quotation_vendor')->insert([
                    'vendor_id' => $vendor->id,
                    'quotation_id' => $quotation->id,
                ]);

                $vendor->user->notify(new \Modules\Quotation\Notifications\NewQuotationNotification($quotation));
            }

            // Mail::send('email.quotation', $quotation,  function ($message) use ($request) {
            //     $message->to('info@sastowholesale.com', 'Admin')
            //         ->subject('Quotation Received');
            //     $message->from($request->email, $request->first_name);
            // });

            DB::commit();

            return response()->json(['status' => 'successful', 'message' => 'Quotation Submitted successfully.', 'data' => $quotation]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Quotation $quotation)
    {
        if(!auth()->user()->hasAnyRole('super_admin|admin')) {
            $vendorId = auth()->user()->vendor->id;
            abort_unless($quotation->vendors->pluck('id')->contains($vendorId), 403);
        }
        
        $quotation->loadMissing('vendors');

        return view('quotation::show', compact('quotation'));
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
