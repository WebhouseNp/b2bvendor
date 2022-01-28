<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Profile;
use Modules\Front\Transformers\CustomerResource;

class CustomerApiController extends Controller
{

    public function index()
    {
        return view('front::index');
    }

    public function show(Profile $profile)
    {
        // $profile->load('user');
        return CustomerResource::make($profile);
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

    public function getAddress()
    {
        return response()->json([
            'data' => auth()->user()->addresses
        ], 200);
    }
}
