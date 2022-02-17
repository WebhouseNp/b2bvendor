<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Front\Transformers\ProductCollection;
use Modules\Front\Transformers\ProductResource;
use Modules\Product\Entities\Product;
use Modules\Subcategory\Entities\Subcategory;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO::Append query string
        $products = Product::with(['category', 'ranges'])
            ->when(request()->filled('q'), function ($query) {
                return $query->where('title', 'like', '%' . request()->q . '%');
            })
            ->when(request()->filled('cat'), function ($query) {
                return $query->where('category_id', request()->cat);
            })
            ->when(request()->filled('subcat'), function ($query) {
                $subCategory = Subcategory::where('slug', request()->subcat)->first();
                return $query->where('subcategory_id', $subCategory->id);
            })
            ->when(request()->filled('from_vendor'), function ($query) {
                return $query->where('user_id', request()->from_vendor);
            })
            ->active()
            ->orderBy('created_at', 'DESC')->paginate(request('per_page') ?? 18);

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
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $product->load(['category', 'ranges', 'productimage', 'user.vendor']);

        return ProductResource::make($product);
    }

    // New Arrivals
    public function getNewArrivals()
    {
        $products = Product::with('ranges')
            ->where('type', 'new')
            ->where('status', 'active')
            ->active()
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();

        return ProductResource::collection($products)->hide([
            'highlight',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'meta_keyphrase',
        ]);
    }

    // Top Products
    public function getTopProducts()
    {
        $products = Product::with('ranges')
            ->where('type', 'top')
            ->where('status', 'active')
            ->active()
            ->orderBy('created_at', 'DESC')
            ->take(4)->get();

        return ProductResource::collection($products->shuffle()->all())->hide([
            'highlight',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'meta_keyphrase',
        ]);
    }

    // Sasto wholesale mall Products
    public function sastoWholesaleMallProducts()
    {
        $products = Product::with('ranges')
            ->where('id', sasto_wholesale_store_id())
            ->where('status', 'active')
            ->active()
            ->orderBy('created_at', 'DESC')
            ->take(18)->get();

        return ProductResource::collection($products->shuffle()->all())->hide([
            'highlight',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'meta_keyphrase',
        ]);
    }

    public function youMayLike()
    {
        $products = Product::with('ranges')
            ->where('status', 'active')
            ->active()
            ->orderBy('created_at', 'DESC')
            ->take(18)->get();

        return ProductResource::collection($products->shuffle()->all())->hide([
            'highlight',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'meta_keyphrase',
        ]);
    }
}
