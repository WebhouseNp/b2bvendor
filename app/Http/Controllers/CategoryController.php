<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::where('publish', 1)->get();
        return response()->json(['data'=>$categories, 'status_code'=>200]);
    }
}
