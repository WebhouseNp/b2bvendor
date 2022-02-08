<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Front\Transformers\VendorResource;
use Modules\User\Entities\Vendor;

class VendorApiController extends Controller
{
    public function index()
    {
        $vendors = Vendor::whereHas('user', function ($query) {
            $query->published()->approved()->verified();
        })
            ->when(request()->filled('q'), function ($query) {
                return $query->where('shop_name', 'like', '%' . request()->q . '%');
            })
            ->paginate(20);

        return VendorResource::collection($vendors)->hide([
            'description',
        ]);
    }

    public function show(Vendor $vendor)
    {
        $vendor->load('user');

        return VendorResource::make($vendor);
    }

    public function showByUserId($userId)
    {
        $vendor = Vendor::with('user')->where('user_id', $userId)->firstOrFail();

        return VendorResource::make($vendor);
    }

    public function getLatestVendors()
    {
        $vendors = Vendor::whereHas('user', function ($query) {
            $query->published()->approved()->verified();
        })
            ->latest()
            ->limit(10)
            ->get()->map(function ($vendor) {
                return [
                    'id' => $vendor->id,
                    'shop_name' => $vendor->shop_name,
                    'image_url' => $vendor->imageUrl(),
                ];
            });

        return response()->json($vendors->shuffle()->all(), 200);
    }
}
