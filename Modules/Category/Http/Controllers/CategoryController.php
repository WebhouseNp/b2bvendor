<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Validator;
use Image;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('category::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('category::create');
    }

    public function createcategory(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:255',
            'image' => 'mimes:jpg,jpeg,png',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
            exit;
        }
        
        $value = $request->except('image', 'publish');
        $value['publish'] = is_null($request->publish) ? 0 : 1;
        $value['is_featured'] = is_null($request->is_featured) ? 0 : 1;
        $value['include_in_main_menu'] = is_null($request->include_in_main_menu) ? 0 : 1;
        $value['does_contain_sub_category'] = is_null($request->does_contain_sub_category) ? 0 : 1;

        if($request->image){
            $image = $this->imageProcessing('img-', $request->file('image'));
            $value['image'] = $image;
        }

        DB::beginTransaction();
        $data = Category::create($value);
        DB::commit();
        return response()->json(['status' => 'successful', 'message' => 'Category created successfully.', 'data' => $data]);
    }

    public function allCategories()
    {
        $details = Category::orderBy('created_at', 'desc')->get();
        $view = \View::make("category::categoriesTable")->with('details', $details)->render();

        return response()->json(['html' => $view, 'status' => 'successful', 'data' => $details]);
    }

    public function deletecategory(Request $request,  Category $category)
    {
            // $category = Category::findorFail($request->id);
            // if ($category->image) {
            //     $this->unlinkImage($category->image);
            // }
            $category->delete();

      return response()->json([
        'status' => 'successful',
        "message" => "Category deleted successfully!"
      ], 200);
        

    }

    public function editcategory(Request $request)
    {
        try{
            $category = Category::findorFail($request->id);

      return response()->json([
        "data" => $category
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function updatecategory(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'image' => 'mimes:jpg,jpeg,png',
            ]);
    
            if($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            $category = Category::findorFail($request->id);
            $value = $request->except('publish','_token');
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            $value['is_featured'] = is_null($request->is_featured) ? 0 : 1;
            $value['include_in_main_menu'] = is_null($request->include_in_main_menu) ? 0 : 1;
            $value['does_contain_sub_category'] = is_null($request->does_contain_sub_category) ? 0 : 1;
            if ($request->image) {
            $image = Category::findorFail($request->id);
                if ($image->image) {
                    $thumbPath = public_path('images/thumbnail');
                    $listingPath = public_path('images/listing');
                    if((file_exists($thumbPath . '/' . $image->image)) && (file_exists($listingPath . '/' . $image->image))){
                        unlink($thumbPath . '/' . $image->image);
                        unlink($listingPath . '/' . $image->image);
                    }
                }
                $image = $this->imageProcessing('img-', $request->file('image'));
                $value['image'] = $image;
            }
            $success = $category->update($value);
      return response()->json([
        'status' => 'successful',
          "data" => $value,
        "message" => "category updated successfully"
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('category::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('category::edit',compact('id'));
    }

    public function view($id)
    {
        return view('category::view', compact('id'));
    }

    public function viewCategory(Request $request)
    {
        try{
            $category = Category::findorFail($request->id);
      return response()->json([
        "message" => "Category view!",
        'data' => $category
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
    public function imageProcessing($type, $image)
    {
        $input['imagename'] = $type . time() . '.' . $image->getClientOriginalExtension();
        $thumbPath = public_path() . "/images/thumbnail";
        if (!File::exists($thumbPath)) {
            File::makeDirectory($thumbPath, 0777, true, true);
        }
        $listingPath = public_path() . "/images/listing";
        if (!File::exists($listingPath)) {
            File::makeDirectory($listingPath, 0777, true, true);
        }
        $img1 = Image::make($image->getRealPath());
        $img1->fit(99, 88)->save($thumbPath . '/' . $input['imagename']);


        $img2 = Image::make($image->getRealPath());
        $img2->save($listingPath . '/' . $input['imagename']);

        $destinationPath = public_path('/images');
        return $input['imagename'];
    }

    public function unlinkImage($imagename)
    {
        $thumbPath = public_path('images/thumbnail/') . $imagename;
        $mainPath = public_path('images/main/') . $imagename;
        $listingPath = public_path('images/listing/') . $imagename;
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }

        if (file_exists($mainPath)) {
            unlink($mainPath);
        }

        if (file_exists($listingPath)) {
            unlink($listingPath);
        }

        if (file_exists($documentPath)) {
            unlink($documentPath);
        }
        return;
    }
}
