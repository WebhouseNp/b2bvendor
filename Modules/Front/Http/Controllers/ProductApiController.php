<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Front\Transformers\ProductCollection;
use Modules\Front\Transformers\ProductResource;
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
            ->when(request()->has('q'), function($query) {
                return $query->where('title', 'like', '%' . request()->q . '%');
            })
            ->where('status', 'active')->orderBy('created_at', 'DESC')->paginate(request('per_page') ?? 15);

        return ProductResource::collection($products)->hide([
            'highlight',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'meta_keyphrase',
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'ranges', 'productimage']);

        return ProductResource::make($product);
    }
}
