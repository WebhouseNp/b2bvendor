<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Partner\Entities\PartnerType;

class PartnerApiController extends Controller
{
    public function __invoke()
    {
        $partners = PartnerType::with('partners')->positioned()->get();
        return $partners;
    }
}
