<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO::Append query string
        $products = Product::with(['category', 'ranges'])
            ->where('status', 'active')->orderBy('created_at', 'DESC')->paginate(request('per_page') ?? 15);

        // TODO::Use resource collection
        return response()->json($products, 200);
    }


    /**
     * Show the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'ranges', 'productimage']);

        // TODO::Use resource
        return response()->json($product, 200);
    }
}
