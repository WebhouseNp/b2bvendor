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
    public function index($type = null)
    {
        $details = Product::with('user.vendor')
            // ->without('user.roles')
            ->when(request()->filled('search'), function ($query) {
                return $query->where('title', 'like', '%' . request('search') . "%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        if (auth()->user()->hasRole('vendor')) {
            if ($type == 'all') {
                $details =  Product::when(request()->filled('search'), function ($query) {
                    return $query->where('title', 'like', '%' . request('search') . "%");
                })
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10)
                    ->withQueryString();
            }
        }
        return view('product::index', compact('details'));
    }

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
                'shipping_charge'          => 'nullable|numeric',
                // 'type'              => 'required',
                'category_id'       => 'required|numeric|exists:categories,id',
                'meta_title'        => 'nullable|string|max:200',
                'meta_description'  => 'nullable|string',
                'keyword'           => 'nullable|string|max:200',
                'meta_keyphrase'    => 'nullable|string|max:200',
                // 'status'            => 'required|in:active,inactive',
                'image' =>  'mimes:jpg,jpeg,png|max:3000',

            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            DB::beginTransaction();

            $value = $request->except('image');
            $value['is_top'] = $request->has('is_top') ? true : false;
            $value['is_new_arrival'] = $request->has('is_new_arrival') ? true : false;
            if ($request->image) {
                $image = $this->imageProcessing('img-', $request->file('image'));
                $value['image'] = $image;
            }
            $data = Product::create($value);
            $product = $request->all();
            foreach ($product['from'] as $key => $val) {
                if (!empty($val)) {
                    $range = new Range();
                    $range->product_id = $data->id;
                    $range->from = $val;
                    $range->to = $product['to'][$key];
                    $range->price = $product['prices'][$key];
                    $range->save();
                }
            }
            DB::commit();
            return response()->json(['status' => 'successful', 'message' => 'Product created successfully.', 'data' => $data]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        return view('product::show');
    }

    public function view($id)
    {
        $product = Product::where('id', $id)->with('ranges', 'productimage')->first();
        return view('product::view', compact('id', 'product'));
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
            return redirect()->route('product.index', ['type' => 'all']);
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
        return redirect()->route('product.index', ['type' => 'all']);
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

    public function edit($id)
    {
        $product = Product::where('id', $id)->with('ranges')->first();
        return view('product::edit', compact('id', 'product'));
    }

    public function editproduct(Request $request)
    {
        try {
            $product = Product::where('id', $request->id)->with(['category'])->first();
            $categories = Category::where('publish', 1)->with('subcategory')->get();
            $subcategory = Subcategory::where('category_id', $product->category->id)->get();
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

    public function updateproduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string',
            'shipping_charge'   => 'nullable|numeric',
            // 'type'              => 'required',
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
        $value = $request->except('image');
        $value['is_top'] = $request->has('is_top') ? true : false;
        $value['is_new_arrival'] = $request->has('is_new_arrival') ? true : false;
        if ($request->image) {
            if ($product->image) {
                $thumbPath = public_path('images/thumbnail');
                $listingPath = public_path('images/listing');
                if ((file_exists($thumbPath . '/' . $product->image)) && (file_exists($listingPath . '/' . $product->image))) {
                    unlink($thumbPath . '/' . $product->image);
                    unlink($listingPath . '/' . $product->image);
                }
            }
            $image = $this->imageProcessing('img-', $request->file('image'));
            $value['image'] = $image;
        }
        $success = $product->update($value);
        if (count($product->ranges)) {
            $product->ranges()->delete();
        }
        $product = $request->all();
        foreach ($product['from'] as $key => $val) {
            if (!empty($val)) {
                $range = new Range();
                $range->product_id = $request->id;
                $range->from = $val;
                $range->to = $product['to'][$key];
                $range->price = $product['prices'][$key];
                $range->save();
            }
        }
        return response()->json([
            'status' => 'successful',
            "data" => $value,
            "message" => "product updated successfully"
        ], 200);
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
        $listingPath = public_path('images/listing/') . $imagename;
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }
        if (file_exists($listingPath)) {
            unlink($listingPath);
        }
        return;
    }
}
