<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Vendor;

class VendorApiController extends Controller
{
    public function index()
    {
        $vendors = Vendor::
        when(request()->filled('q'), function($query) {
            return $query->where('shop_name', 'like', '%' . request()->q . '%');
        })
        ->paginate(20);

        return $vendors;
    }

    public function show(Vendor $vendor)
    {
        $vendor->load('user');
        return $vendor;
    }
  
}
