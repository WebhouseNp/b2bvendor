<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Offer\Entities\Offer;
use Modules\Brand\Entities\Brand;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductImage;
use Validator, File;
use Image;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\ProductCategory\Entities\ProductCategory;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('manageProducts');

        $details = Product::with('user.vendor')
            ->when(request()->filled('search'), function ($query) {
                return $query->where('title', 'like', '%' . request('search') . "%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('product::index', compact('details'));
    }

    public function getcategories()
    {
        $categories = Category::where('publish', 1)->get();
        return response()->json(['data' => $categories, 'status_code' => 200]);
    }

    // Not used
    public function getoffers()
    {
        $offers = Offer::where('publish', 1)->get();
        return response()->json(['data' => $offers, 'status_code' => 200]);
    }

    // Not used
    public function allbrands()
    {
        $brands = Brand::where('publish', 1)->get();
        return response()->json(['data' => $brands, 'status_code' => 200]);
    }

    public function getsubcategory(Request $request)
    {
        $categories = Category::find($request->category_id);
        return response()->json(['category' => $categories]);
    }

    public function getProductCategory(Request $request)
    {
        $request->validate([
            'subcategory_id' => ['required', 'exists:subcategories,id'],
        ]);

        $productCategories  = ProductCategory::select(['id', 'name', 'publish'])
            ->where('subcategory_id', $request->subcategory_id)
            ->published()->get();

        return response()->json(['data' => $productCategories]);
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
        $this->authorize('manageProducts');

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

    public function productImage(Product $product)
    {
        $updateMode = true;

        return view('product::image', compact('product', 'updateMode'));
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
