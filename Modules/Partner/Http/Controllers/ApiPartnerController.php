<?php

namespace Modules\Partner\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\Partner;
use Modules\Partner\Transformers\PartnerCollection;
use Modules\Partner\Transformers\PartnerResource;

class ApiPartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::published()->get();

        return new PartnerCollection($partners);
    }
    
}
