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

class ProductImageController extends Controller
{
    function upload($id,Request $request)
    {
     $product = Product::find($id);
        if (!$product) {
            $request->session()->flash('error', 'Invalid Product Information.');
            return redirect()->route('product.index',['type'=>'all']);
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
        if ($request->file()) {
            $temp = [];
            foreach ($request->file() as $key => $other_image) {
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
        return response()->json([
            'status' => 'successful',
            "message" => "product updated successfully"
        ], 200);
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

}
