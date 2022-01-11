<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use App\Models\User;
use Modules\Offer\Entities\Offer;
use Modules\Brand\Entities\Brand;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Variant;
use Modules\Product\Entities\Sku;
use Modules\ProductAttribute\Entities\Productattribute;
use Modules\ProductAttribute\Entities\CategoryAttribute;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Product\Entities\ProductImage;
use Modules\Product\Entities\Range;
use Modules\Product\Entities\Product_attribute_value;
use Validator, DB, File;
use Image;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $details = Product::when(request()->filled('search'), function($query) {
            return $query->where('title', 'like', '%'. request('search') . "%");
            // ->orWhere('highlight', 'like', '%'. request('search'));
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();
        return view('product::index',compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $attributes = Productattribute::where('publish', 1)->get();
        return view('product::create', compact('attributes'));
    }

    public function getcategories()
    {
        $categories = Category::where('publish', 1)->get();
        return response()->json(['data' => $categories, 'status_code' => 200]);
    }

    public function getproductattributes(Request $request)
    {

        if ($request->cat_id) {
            $attributes = [];
            // $attributes = Productattribute::where('category_id',$request->cat_id)->whereNull('subcategory_id')->where('publish',1)->get();
            $category  = Category::where('id', $request->cat_id)->where('publish', 1)->first();
            $catAttributes = CategoryAttribute::where('category_id', $category->id)->get();
            foreach ($catAttributes as $att) {
                $attributes[] = ProductAttribute::where('id', $att->attribute_id)->where('publish', 1)->first();
            }
        }
        if ($request->sub_cat_id) {
            $attributes = [];
            $subcategory  = Subcategory::where('id', $request->sub_cat_id)->where('publish', 1)->first();
            $catAttributes = CategoryAttribute::where('subcategory_id', $subcategory->id)->get();
            foreach ($catAttributes as $att) {
                $attributes[] = Productattribute::where('id', $att->attribute_id)->where('publish', 1)->first();
            }
        }
        $html = View('product::product-attribute', compact('attributes'))->render();
        return response()->json(['data' => $attributes, 'html' => $html, 'status_code' => 200]);
    }

    public function getoffers()
    {
        $offers = Offer::where('publish', 1)->get();
        return response()->json(['data' => $offers, 'status_code' => 200]);
    }

    public function allbrands()
    {
        $brands = Brand::where('publish', 1)->get();
        return response()->json(['data' => $brands, 'status_code' => 200]);
    }

    public function approveproduct(Request $request){
        try {
            $product = Product::findorFail($request->id);
            $product['isApproved'] = 'approved';
            $user = $product->user;
            $user_info = [
                'name' => $user->name
            ];
            $product->update();
            Mail::send('email.productapproved', $user_info, function ($message) use ($user_info, $user) {
                $message->to($user->email,  $user->name)

                    ->subject('Product Approved!! ');
                $message->from('info@sastowholesale.com', 'Admin');
             });
            return response()->json([
                'status' => 'successful',
                "message" => "Product approved successfully!"
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function nonapprovalnote(Request $request){
        try {
            $product = Product::findorFail($request->id);
            $product['isApproved'] = 'rejected';
            $product['non_approval_note'] = $request->non_approval_note;
            $product->update();
            $user_info = [
                'name' => $product->user->name,
                'note' => $request->non_approval_note
            ];
            Mail::send('email.productrejected',$user_info,  function ($message) use ($user_info, $product){
                $message->to($product->user->email, $product->user->name)

                    ->subject('Product Rejected ' . $product->user->name);
                $message->from('info@sastowholesale.com', 'admin');
            });
            return response()->json([
                'status' => 'true',
                "message" => "Note added successfully!"
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function getsubcategory(Request $request)
    {
        $categories = Category::find($request->category_id);
        if ($categories->does_contain_sub_category == 1) {
            $subcategory = $categories->subcategory;
            return response()->json(['data' => $subcategory]);
        } else {
            return response()->json(['category' => $categories]);
        }
    }

    public function createproduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title'             => 'required|string',
                // 'price'             => 'required|numeric',
                'discount'          => 'nullable|numeric',
                'type'              => 'required',
                'category_id'       => 'required|numeric|exists:categories,id',
                'meta_title'        => 'nullable|string|max:200',
                'meta_description'  => 'nullable|string',
                'keyword'           => 'nullable|string|max:200',
                'meta_keyphrase'    => 'nullable|string|max:200',
                // "variant"    => "required|array",
                // "variant[price].*"  => "required|numeric",
                // 'status'            => 'required|in:active,inactive',
                'image' =>  'mimes:jpg,jpeg,png|max:3000',

            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()],422);
                exit;
            }

            $value = $request->except('image', 'best_seller', 'essential');

            $value['best_seller'] = is_null($request->best_seller) ? 0 : 1;
            $value['essential'] = is_null($request->essential) ? 0 : 1;
            $value['user_id'] = $request->user_id;
            $user = User::where('id',$value['user_id'])->first();
            $role = checkRole($user->id);
            if($role == 'vendor'){
                $value['isApproved'] = 'not_approved';
            } else {
                $value['isApproved'] = 'approved';

            }
            if ($request->image) {
                $image = $this->imageProcessing('img-', $request->file('image'));
                $value['image'] = $image;
            }

            $data = Product::create($value);
            $product = $request->all();
            foreach($product['from'] as $key=>$val){
                if(!empty($val)){
                    $range = new Range();
                    $range->product_id = $data->id;
                    $range->from = $val;
                    $range->to = $product['to'][$key];
                    $range->price = $product['prices'][$key];
                    $range->save();
                }
            }
            $user_info = [
                'name'  => $user->name,
            ];
            if($role == 'vendor'){
                Mail::send('email.productapproval',$user_info,  function ($message) use ($user_info, $user){
                    $message->to($user->email,  $user->name)
    
                        ->subject('Product submitted for admin approval ' . $user->name);
                    $message->from('info@sastowholesale.com', 'Admin');
                });
            }
            

            // $req = $request->except('_token','title','category_id','subcategory_id','offer_id','brand_id','price','discount','quantity','best_seller','type','product_type','highlight','description','meta_title','meta_description','keyword','meta_keyphrase','status','image');
            // if ($request->has('product_type')) {
            //     if ($request->has('variant')) {
            //         $variant_sku = $request->variant['sku'];
            //         $variant_price = $request->variant['price'];
            //         $variant_discount_price = $request->variant['discount_price'];
            //         $variant_stock = $request->variant['stock'];
            //         for ($i = 1; $i < count($variant_sku); $i++) {
            //             $sku = new Sku;
            //             $sku->product_id = $data->id;
            //             $sku->price = $variant_price[$i];
            //             $sku->discount_price = $variant_discount_price[$i];
            //             $sku->stock = $variant_stock[$i];
            //             $sku->sku = $data->slug . '' . Str::slug($variant_sku[$i], '_');
            //             $sku->save();
            //             $variantsForEachSku = array_keys($request->variant);
            //             foreach ($variantsForEachSku as $idOfAttribute) {
            //                 if (is_int($idOfAttribute)) {
            //                     $variant = new Variant;
            //                     $variant->sku_id = $sku->id;
            //                     $variant->attribute_id = $idOfAttribute;
            //                     $variant->attribute_value = $request->variant[$idOfAttribute][$i];
            //                     $variant->save();
            //                 }
            //             }
            //         }
            //     }
            // }
            return response()->json(['status' => 'successful', 'message' => 'Product created successfully.', 'data' => $data]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function productRequest(){
        $details =  Product::when(request()->filled('search'), function($query) {
            return $query->where('title', 'like', '%'. request('search') . "%");
            })
            ->notapproved()->latest()->paginate(10)
            ->withQueryString();
        return view('product::productrequest',compact('details'));
    }

    public function VendorProductRequest(){
        $details =  Product::when(request()->filled('search'), function($query) {
            return $query->where('title', 'like', '%'. request('search') . "%");
            })
            ->where('user_id',Auth::id())->notapproved()->latest()->paginate(10)
                    ->withQueryString();
        return view('product::allproducts',compact('details'));
    }
    
    public function allVendorProducts(){
        $details =  Product::when(request()->filled('search'), function($query) {
            return $query->where('title', 'like', '%'. request('search') . "%");
            })
            ->where('user_id',Auth::id())
            ->active()->approved()
            ->with(['category', 'brand', 'offer','user'])
            ->latest()
            ->paginate(5)
            ->withQueryString();
        return view('product::allproducts',compact('details'));
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
        return view('product::show');
    }

    public function view($id)
    {
        $product = Product::where('id', $id)->with('ranges','productimage')->first();
        // $skus = $product->skus;
        // $attributes = [];
        // if ($product->category_id) {
        //     $cAttributes = CategoryAttribute::where('category_id', $product->category->id)->whereNull('subcategory_id')->get();
        //     foreach ($cAttributes as $attr) {
        //         $attributes[] = Productattribute::where('id', $attr->attribute_id)->first();
        //     }
        // }
        // if ($product->subcategory_id) {
        //     $attributes = [];
        //     $sAttributes = CategoryAttribute::where('subcategory_id', $product->subcategory->id)->whereNull('category_id')->get();
        //     foreach ($sAttributes as $attr) {
        //         $attributes[] = Productattribute::where('id', $attr->attribute_id)->first();
        //     }
        // }
        // return view('product::view', compact('id' ,'product', 'skus', 'attributes'));
        return view('product::view', compact('id' ,'product'));
    }

    public function viewProduct(Request $request)
    {
        try {
            $product = Product::where('id', $request->id)->with(['category', 'brand', 'offer'])->first();
            return response()->json([
                "message" => "Product view!",
                'data' => $product
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function deleteproduct(Request $request)
    {
        try {
            $product = Product::findorFail($request->id);
            if ($product->image) {
                $this->unlinkImage($product->image);
            }
            $product->delete();

            return response()->json([
                'status' => 'successful',
                "message" => "Product deleted successfully!"
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function productImage($id)
    {
        $product_info = Product::find($id);
        if (!$product_info) {
            $request->session()->flash('error', 'Invalid Product Information.');
        }
        return view('product::image', compact('id', 'product_info'));
    }

    public function updateProductImage($id, Request $request)
    {
        $product = Product::find($id);
        if (!$product) {
            $request->session()->flash('error', 'Invalid Product Information.');
            return redirect()->route('product.index');
        }
        $valid = Validator::make($request->all(), [
            'image.*' =>  'nullable|mimes:jpg,jpeg,png|max:2000|dimensions:width<=765,height<=1020',
        ]);
        if ($valid->fails()) {
            $i = 0;
            // 'required' => 'The :attribute field is required.'
            foreach ($valid->messages()->getMessages() as  $key => $message) {
                $message = 'The  image on ' . $key . ' size should be 720px width and 1020px height with jpg, jpeg, png format';
                $i++;
                $errorimage[] = $message;
            }

            return redirect()->back()->with('image_warning', $errorimage);
        }
        if ($request->image) {
            // $img_count = count($request->image);
            // if (($img_count + $db_image) > 8) {
            //     $request->session()->flash('error', 'Sorry, You have already uploaded ' . $db_image . ' images. You can upload images upto 6 Nos for a product.');
            //     return redirect()->route('edit-product', $id);
            // }
            $temp = [];
            foreach ($request->image as $key => $other_image) {
                $image_title = $product->slug . "-image-" . $key . rand(0, 10);
                $file_name = $this->OtherImage($other_image, $image_title);
                if ($file_name) {
                    $temp[] = array('product_id' => $product->id, 'images' => $file_name);
                }
            }
            if (!empty($temp)) {
                $productimage = new ProductImage();
                $productimage->insert($temp);
            }
        }
        $request->session()->flash('success', 'Product detail updated Successfully.');
        return redirect()->route('product.index');
    }

    public function deleteImageById(Request $request)
    {
        $image_data  = productImage::find($request->id);

        if (!$image_data) {
            return response()->json(['status' => false, 'message' => ["Invalid Image information."]]);
        }
        $image = $image_data->images;
        $del = $image_data->delete();
        if ($del) {
            if (isset($image) && !empty($image) && file_exists(public_path() . '/uploads/product/other-image/' . $image)) {
                unlink((public_path() . '/uploads/product/other-image/' . $image));
            }
            return response()->json([
                'status' => true, 'message' => "Product image deleted successfully."
            ]);
        } else {
            return response()->json(['status' => false, 'message' => ["Sorry! Product Image could not be deleted at this time please reload the page page and try again."]]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->with('ranges')->first();
        // $ranges = Range::where('product_id',$id)->get();
        // $skus = $product->skus;
        // $attributes = [];
        // if ($product->category_id) {
        //     $cAttributes = CategoryAttribute::where('category_id', $product->category->id)->whereNull('subcategory_id')->get();
        //     foreach ($cAttributes as $attr) {
        //         $attributes[] = Productattribute::where('id', $attr->attribute_id)->first();
        //     }
        // }
        // if ($product->subcategory_id) {
        //     $attributes = [];
        //     $sAttributes = CategoryAttribute::where('subcategory_id', $product->subcategory->id)->whereNull('category_id')->get();
        //     foreach ($sAttributes as $attr) {
        //         $attributes[] = Productattribute::where('id', $attr->attribute_id)->first();
        //     }
        // }
        // return view('product::edit', compact('id', 'product', 'skus', 'attributes'));
        return view('product::edit', compact('id', 'product'));
    }

    public function editproduct(Request $request)
    {
        try {
            $product = Product::where('id',$request->id)->with(['category'])->first();
            $categories = Category::where('publish', 1)->with('subcategory')->get();
            $subcategory = Subcategory::where('category_id',$product->category->id)->get();
            $skus = $product->skus;
            $attributes = [];
            if ($product->category_id) {
                $cAttributes = CategoryAttribute::where('category_id', $product->category->id)->whereNull('subcategory_id')->get();
                foreach ($cAttributes as $attr) {
                    $attributes[] = Productattribute::where('id', $attr->attribute_id)->first();
                }
            }
            if ($product->subcategory_id) {
                $attributes = [];
                $sAttributes = CategoryAttribute::where('subcategory_id', $product->subcategory->id)->whereNull('category_id')->get();
                foreach ($sAttributes as $attr) {
                    $attributes[] = Productattribute::where('id', $attr->attribute_id)->first();
                }
            }

            return response()->json([
                "data" => $product,
                "categories" => $categories,
                "subcategory" => $subcategory,
                "skus" => $skus,
                "attributes" => $attributes
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function deleteSku(Request $request){
        $sku = Sku::where('id',$request->id)->delete();
        return response()->json([
            "status" => "true",
            "message" => "Product Variant Deleted Succesfully!",
        ], 200);

    }

    public function updateproduct(Request $request)
    {
        // try {
            $validator = Validator::make($request->all(), [
                'title'             => 'required|string',
                'price'             => 'required|numeric',
                'discount'          => 'nullable|numeric',
                'type'              => 'required',
                'category_id'       => 'required|numeric|exists:categories,id',
                'meta_title'        => 'nullable|string|max:200',
                'meta_description'  => 'nullable|string',
                'keyword'           => 'nullable|string|max:200',
                'meta_keyphrase'    => 'nullable|string|max:200',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            $product = Product::findorFail($request->id);
            $value = $request->except('image', 'best_seller', 'essential');

            $value['best_seller'] = is_null($request->best_seller) ? 0 : 1;
            $value['essential'] = is_null($request->essential) ? 0 : 1;
            if ($request->image) {
                if ($product->image) {
                    $thumbPath = public_path('images/thumbnail');
                    $listingPath = public_path('images/listing');
                    if ((file_exists($thumbPath . '/' . $image->image)) && (file_exists($listingPath . '/' . $image->image))) {
                        unlink($thumbPath . '/' . $image->image);
                        unlink($listingPath . '/' . $image->image);
                    }
                }
                $image = $this->imageProcessing('img-', $request->file('image'));
                $value['image'] = $image;
            }
            $success = $product->update($value);
            if(count($product->ranges)){
                    $product->ranges()->delete();
    
                }
                $product = $request->all();
                foreach($product['from'] as $key=>$val){
                    if(!empty($val)){
                        $range = new Range();
                        $range->product_id = $request->id;
                        $range->from = $val;
                        $range->to = $product['to'][$key];
                        $range->price = $product['prices'][$key];
                        $range->save();
                    }
                }
            // if(count($product->skus)){
            //     $product->skus()->delete();

            // }
            // if ($request->has('variant')) {
            //     $variant_sku = $request->variant['sku'];
            //     $variant_price = $request->variant['price'];
            //     $variant_discount_price = $request->variant['discount_price'];
            //     $variant_stock = $request->variant['stock'];
            //     for ($i = 1; $i < count($variant_sku); $i++) {
            //         $sku = new Sku;
            //         $sku->product_id = $product->id;
            //         $sku->price = $variant_price[$i];
            //         $sku->discount_price = $variant_discount_price[$i];
            //         $sku->stock = $variant_stock[$i];
            //         $sku->sku = $product->slug . '' . Str::slug($variant_sku[$i], '_');
            //         $sku->save();
            //         $variantsForEachSku = array_keys($request->variant);
            //         foreach ($variantsForEachSku as $key=>$idOfAttribute) {
            //                 if (is_int($idOfAttribute)) {
            //                     $variant = new Variant;
            //                     $variant->sku_id = $sku->id;
            //                     $variant->attribute_id = $idOfAttribute;
            //                     $variant->attribute_value = $request->variant[$idOfAttribute][$i];
            //                     $variant->save();
                            
            //                 }
                        
            //         }
            //     }
            // }
            return response()->json([
                'status' => 'successful',
                "data" => $value,
                "message" => "product updated successfully"
            ], 200);
        // } catch (\Exception $exception) {
        //     return response([
        //         'message' => $exception->getMessage()
        //     ], 400);
        // }
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

    public function OtherImage($image,  $image_title)
    {
        $image_ext = $image->getClientOriginalExtension();
        $image_name = $image_title . '.' . $image_ext;
        $original_path = public_path() . "/uploads/product/other-image";
        if (!File::exists($original_path)) {
            File::makeDirectory($original_path, 0777, true, true);
        }
        $keep_original = Image::make($image->getRealPath());
        $keep_original->save($original_path . '/' . $image_name);

        return $image_name;
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
