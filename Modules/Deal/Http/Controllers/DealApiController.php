<?php

namespace Modules\Deal\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Product;

class DealApiController extends Controller
{
    public function customerSearch()
    {
        // TODO::must be a vendor
        $users = User::where('name', 'like', request('q') . '%')
            ->orWhere('email', 'like', request('q') . '%')
            ->select('id', 'name', 'email')->get();

        return response()->json(['data' => $users]);
    }

    public function productSearch()
    {
        // TODO::must be a vendor
        $products = Product::where('user_id', Auth::id())
            ->select('id', 'title')->get()->map( function($product){
                $product['image_url']='https://dummyimage.com/50/5b43c4/ffffff';
            });
        return response()->json(['data' => $products]);
    }
}
