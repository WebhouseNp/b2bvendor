<?php

namespace Modules\Partner\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\Partner;
use Modules\Partner\Entities\PartnerType;
use Modules\Partner\Transformers\PartnerCollection;
use Modules\Partner\Transformers\PartnerResource;
use Modules\Partner\Transformers\PartnerTypeCollection;

class ApiPartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::published()->get();

        return new PartnerCollection($partners);
    }

    public function partnerTypes(){
        $partners = PartnerType::publish()->with('partners')->get();
        return new PartnerTypeCollection($partners);
    }
    
}
