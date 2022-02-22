<?php

namespace Modules\ProductCategory\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\ProductCategory\Entities\ProductCategory;
use Modules\ProductCategory\Http\Requests\ProductCategoryRequest;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $productCategories = ProductCategory::with('subcategory')->latest()->get();

        return view('productcategory::index', compact('productCategories'));
    }

    public function create()
    {
        return $this->showForm(new ProductCategory());
    }

    public function store(ProductCategoryRequest $request)
    {
        $productCategory = new ProductCategory();
        $productCategory->name = $request->name;
        $productCategory->subcategory_id = $request->subcategory_id;
        $productCategory->is_featured = $request->filled('is_featured');
        $productCategory->publish = $request->filled('publish');

        if ($request->has('image')) {
            $productCategory->image = $request->image->store('images/category');
        }
        $productCategory->save();


        return redirect()->route('product-category.index')->with('success', 'Item added successfully.');
    }

    // Not in use
    public function show($id)
    {
        return view('productcategory::show');
    }

    public function edit(ProductCategory $productCategory)
    {
        return $this->showForm($productCategory);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $productCategory->name = $request->name;
        if ($request->filled('slug')) {
            $productCategory->slug = $request->slug;
        }
        $productCategory->subcategory_id = $request->subcategory_id;
        $productCategory->is_featured = $request->filled('is_featured');
        $productCategory->publish = $request->filled('publish');
        if ($request->has('image')) {
            $productCategory->image = $request->image->store('images/category');
        }
        $productCategory->update();

        return redirect()->route('product-category.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Using and API route
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();

        return redirect()->route('product-category.index')->with('success', 'Item deleted successfully.');
    }

    public function showForm(ProductCategory $productCategory)
    {
        $updateMode = false;
        $categoryId = null;
        if ($productCategory->exists) {
            $updateMode = true;
            $categoryId = $productCategory->subcategory->category->id;
        }

        $categories = Category::with('subcategory')
            ->whereHas('subcategory', function ($query) {
                $query->where('publish', true);
            })
            ->get();
        // return $categories;

        return view('productcategory::form', compact('productCategory', 'categories', 'updateMode', 'categoryId'));
    }

    public function changeStatus(ProductCategory $productCategory)
    {
        $productCategory->publish = request()->publish ? true : false;
        $productCategory->update();
    }
}