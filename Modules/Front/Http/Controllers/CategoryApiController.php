<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::with(['subcategory' => function ($query) {
            $query->select(['id', 'name', 'slug', 'category_id', 'image'])->published();
        }])
            ->published()
            ->get()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image_url' => $category->imageUrl(),
                    'is_featured' => $category->is_featured,
                    'subcategory' => $category->subcategory->map(function ($category) {
                        return [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug,
                            'image_url' => $category->imageUrl(),
                        ];
                    })
                ];
            });

        return response()->json($categories, 200);
    }

    public function megamenu()
    {
        $categories = Category::with(['subcategory' => function ($query) {
            $query->select(['id', 'name', 'slug', 'category_id', 'image'])->published();
        }])
            ->where('include_in_main_menu', 1)
            ->published()
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image_url' => $category->imageUrl(),
                    'is_featured' => $category->is_featured,
                    'subcategory' => $category->subcategory
                ];
            });

        return response()->json($categories, 200);
    }

    public function hotCategories()
    {
        $categories = Category::with('subcategory:id,name,slug,category_id')
            ->where('hot_category', 1)
            ->published()
            ->get()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image_url' => $category->imageUrl(),
                    'is_featured' => $category->is_featured,
                    'subcategory' => $category->subcategory
                ];
            });

        return response()->json($categories, 200);
    }

    public function vendorCatgeory(){
        $categories = Category::published()->select('id','name')
            ->get();
            return response()->json($categories, 200);
    }
}
