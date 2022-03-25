<?php

namespace Modules\Partner\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\BecomePartner;

class BecomePartnerController extends Controller
{
    public function index(){
        abort_unless(auth()->user()->hasAnyRole('super_admin|admin'), 403);
        $partners = BecomePartner::get();
        return view('partner::partner-request-index', compact('partners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'company_email' => 'required',
            'address' => 'required',
            'partner_type_id' => 'required|numeric|exists:partner_types,id',
            'company_phone' => 'required',
            'eastablished_year' => 'required',
            'company_web' => 'required',
            'full_name' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);
        
        BecomePartner::create([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'address' => $request->address,
            'eastablished_year' => $request->eastablished_year,
            'partner_type_id' => $request->partner_type_id,
            'company_web' => $request->company_web,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'designation' => $request->designation,
            'phone' => $request->phone
        ]);

        return response()->json(['status' => 'successful', 'message' => 'Form Submitted Successfully.'],200);
    }

    public function viewPartnerRequest(Request $request){
        $detail = BecomePartner::findOrFail($request->id);
        return view('partner::partner-request-view', compact('detail'));
    }
}
