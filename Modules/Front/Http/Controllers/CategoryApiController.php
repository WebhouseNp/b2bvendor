<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;

class CategoryApiController extends Controller
{
    public function megamenu()
    {
        $categories = Category::with('subcategory:id,name,slug,category_id')
            ->published()
            ->get();

        return response()->json($categories, 200);
    }

    public function hotCategories()
    {
        $categories = Category::with('subcategory:id,name,slug,category_id')
            ->where('hot_category', 1)->published()
            ->get();

        return response()->json($categories, 200);
    }
}
