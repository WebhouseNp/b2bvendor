<?php

namespace Modules\subcategory\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Subcategory\Entities\Subcategory;
use Validator;
use Image;
use DB;


class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $details = Subcategory::orderBy('created_at', 'desc')->with('category')->get();
        return view('subcategory::index',compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('subcategory::create');
    }

    public function createsubcategory(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:subcategories|max:255',
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
        // dd($value);
        $data = Subcategory::create($value);
        DB::commit();
        return response()->json(['status' => 'successful', 'message' => 'Sub Category created successfully.', 'data' => $data]);
    }

    public function getcategories(){
        $categories = Category::where('publish', 1)->where('does_contain_sub_category',1)->get();
        return response()->json(['data'=>$categories, 'status_code'=>200]);
    }

    // public function getsubcategories(){
    //     $details = Subcategory::orderBy('created_at', 'desc')->with('category')->get();
    //     $view = \View::make("subcategory::subcategoriesTable")->with('details', $details)->render();
    //     return response()->json(['html' => $view, 'status' => 'successful', 'data' => $details]);
    // }

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
        return view('subcategory::show');
    }

    public function view($id)
    {
        return view('subcategory::view', compact('id'));
    }

    public function viewSubcategory(Request $request)
    {
        try{
            // $subcategory = Subcategory::findorFail($request->id);
            $subcategory = Subcategory::where('id',$request->id)->with('category')->first();


      return response()->json([
        "message" => "Subcategory view!",
        'data' => $subcategory
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function deletesubcategory(Request $request, Subcategory $subcategory)
    {
            // $subcategory = Subcategory::findorFail($request->id);
            // if ($subcategory->image) {
            //     $this->unlinkImage($subcategory->image);
            // }
            $subcategory->delete();

      return response()->json([
        'status' => 'successful',
        "message" => "subcategory deleted successfully!"
      ], 200);
        

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('subcategory::edit',compact('id'));
    }

    public function editsubcategory(Request $request)
    {
        try{
            // $subcategory = Subcategory::findorFail($request->id);
            $categories = Category::where('publish', 1)->get();
            $subcategory = Subcategory::where('id',$request->id)->with('category')->first();
            // dd($subcategory);

      return response()->json([
        "data" => $subcategory,
        'categories' => $categories,
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }

    }

    public function updatesubcategory(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'image' => 'mimes:jpg,jpeg,png',
            ]);
    
            if($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            $subcategory = Subcategory::findorFail($request->id);
            $value = $request->except('publish','_token');
            $value['publish'] = is_null($request->publish) ? 0 : 1;
            $value['is_featured'] = is_null($request->is_featured) ? 0 : 1;
            $value['include_in_main_menu'] = is_null($request->include_in_main_menu) ? 0 : 1;
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
            $success = $subcategory->update($value);
      return response()->json([
        'status' => 'successful',
          "data" => $value,
        "message" => "subcategory updated successfully"
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
        $thumbPath = public_path('images/thumbnail');
        $mainPath = public_path('images/main');
        $listingPath = public_path('images/listing');

        $img1 = Image::make($image->getRealPath());
        $img1->fit(530, 300)->save($thumbPath . '/' . $input['imagename']);


        $img2 = Image::make($image->getRealPath());
        $img2->fit(99, 88)->save($listingPath . '/' . $input['imagename']);

        $destinationPath = public_path('/images');
        return $input['imagename'];
    }

    public function unlinkImage($imagename)
    {
        $thumbPath = public_path('images/thumbnail/') . $imagename;
        $mainPath = public_path('images/main/') . $imagename;
        $listingPath = public_path('images/listing/') . $imagename;
        $documentPath = public_path('document/') . $imagename;
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
