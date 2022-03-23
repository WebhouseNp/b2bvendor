<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Country\Entities\Country;
use Modules\Front\Transformers\ProductCollection;
use Modules\Front\Transformers\ProductResource;
use Modules\Product\Entities\Product;
use Modules\ProductCategory\Entities\ProductCategory;
use Modules\Subcategory\Entities\Subcategory;
use Modules\User\Entities\Vendor;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO::Append query string
        // return request();

        $hasFilters = false;
        $withInVendorIds = [];
        if (request()->filled('seller_type')) {
            $hasFilters = true;
            $vendors = Vendor::whereIn('category', request()->get('seller_type'))->pluck('id');
            foreach ($vendors as $vendor) {
                $withInVendorIds[] = $vendor;
            }
        }

        if (request()->filled('country')) {
            $hasFilters = true;
            $vendors = Vendor::whereIn('country_id', request()->get('country'))->pluck('id');
            foreach ($vendors as $vendor) {
                $withInVendorIds[] = $vendor;
            }
        }

        if (request()->filled('business_type')) {
            $hasFilters = true;
            $vendors = Vendor::whereIn('business_type', request()->get('business_type'))->pluck('id');
            foreach ($vendors as $vendor) {
                $withInVendorIds[] = $vendor;
            }
        }
        logger($withInVendorIds);

        // return $withInVendorIds;

        $products = Product::with(['productCategory', 'ranges', 'user'])
            ->productsfromapprovedvendors()
            ->when(request()->filled('q'), function ($query) {
                return $query->where('title', 'like', '%' . request()->q . '%');
            })
            ->when(request()->filled('cat'), function ($query) {
                $category = Category::where('slug', request()->cat)->first();
                $productCategoryIds = $category->productCategory()->pluck('product_categories.id')->toArray();
                return $query->whereIn('product_category_id', $productCategoryIds);
            })
            ->when(request()->filled('subcat'), function ($query) {
                $subCategory = Subcategory::where('slug', request()->subcat)->first();
                $productCategoryIds = $subCategory->productCategory()->pluck('id')->toArray();
                return $query->whereIn('product_category_id', $productCategoryIds);
            })
            ->when(request()->filled('prod_cat'), function ($query) {
                $productCategory = ProductCategory::where('slug', request()->prod_cat)->first();
                return $query->where('product_category_id', $productCategory->id);
            })
            ->when(request()->filled('from_vendor'), function ($query) {
                return $query->where('user_id', request()->from_vendor);
            })
            ->when($hasFilters, function ($query) use ($withInVendorIds) {
                return $query->whereIn('vendor_id', $withInVendorIds);
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
            ->productsfromapprovedvendors()
            ->active()
            ->firstOrFail();

        $product->load(['productCategory', 'ranges', 'images', 'user.vendor']);

        return ProductResource::make($product);
    }

    public function showById($id)
    {
        $product = Product::where('id', $id)
            ->productsfromapprovedvendors()
            ->active()
            ->firstOrFail();

        $product->load(['productCategory', 'ranges', 'images', 'user.vendor']);

        return ProductResource::make($product);
    }

    // Sasto wholesale mall Products
    public function sastoWholesaleMallProducts()
    {
        $sastoWholesaleStore = Vendor::where('id', sasto_wholesale_store_id())->firstOrFail();

        $products = Product::with(['ranges', 'user'])
            ->productsfromapprovedvendors()
            ->where('user_id', $sastoWholesaleStore->user_id)
            ->active()
            ->orderBy('created_at', 'DESC')
            ->take(settings('sasto_wholesale_mall_home_products_count', 18))->get();

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
        $products = Product::with(['ranges', 'user'])
            ->productsfromapprovedvendors()
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
