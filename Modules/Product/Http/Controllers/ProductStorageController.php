<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Range;
use File;
use Image;
use Illuminate\Support\Facades\DB;
use Modules\Product\Http\Requests\ProductRequest;

class ProductStorageController extends Controller
{
    public function create()
    {
        return $this->showProductForm(new Product());
    }

    protected function showProductForm(Product $product)
    {
        $updateMode = false;
        $product->loadMissing('ranges');
        $subcategory = null;
        $categoryId = null;
        $subcategoryId = null;

        $categories = Category::with([
            'subcategory' => function ($query) {
                $query->published();
            },
            'subcategory.productCategory' => function ($query) {
                $query->published();
            }
        ])->published()->get();

        if ($product->exists) {
            $updateMode = true;

            $subcategory = $product->productCategory->subcategory;
            $categoryId = $subcategory->category->id;
            $subcategoryId = $subcategory->id;
        }

        return view('product::form', compact('product', 'updateMode', 'categories', 'categoryId', 'subcategoryId'));
    }

    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $product = new Product();
            $product->title = $request->title;
            $product->product_category_id = $request->product_category_id;
            $product->shipping_charge = $request->shipping_charge;
            $product->unit = $request->unit;
            $product->highlight = $request->highlight;
            $product->description = $request->description;
            $product->video_link = $request->video_link;
            $product->is_top = $request->has('is_top') ? true : false;
            $product->is_new_arrival = $request->has('is_new_arrival') ? true : false;
            $product->status = $request->status == 'active' ? true : false;

            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_keyword = $request->meta_keyword;
            $product->meta_keyphrase = $request->meta_keyphrase;

            $product->overview = $request->only('payment_mode', 'size', 'brand', 'colors', 'country_of_origin', 'warranty', 'feature', 'use', 'gender', 'age_group');

            if ($request->hasFile('image')) {
                $image = $this->imageProcessing('img-', $request->file('image'));
                $product->image = $image;
            }

            $product->save();

            foreach ($request->from as $key => $val) {
                if (!empty($val)) {
                    $range = new Range();
                    $range->product_id = $product->id;
                    $range->from = $val;
                    $range->to = $request->to[$key] ?? null;
                    $range->price = $request->prices[$key];
                    $range->save();
                }
            }
            DB::commit();

            return response()->json(['status' => 'successful', 'message' => 'Product created successfully.', 'data' => $product]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response([
                'status' => 'unsuccessful',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function edit(Product $product)
    {
        return $this->showProductForm($product);
    }

    public function update(ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $product = Product::findorFail($request->id);
            $product->title = $request->title;
            $product->product_category_id = $request->product_category_id;
            $product->shipping_charge = $request->shipping_charge;
            $product->unit = $request->unit;
            $product->highlight = $request->highlight;
            $product->description = $request->description;
            $product->video_link = $request->video_link;
            $product->is_top = $request->has('is_top') ? true : false;
            $product->is_new_arrival = $request->has('is_new_arrival') ? true : false;
            $product->status = $request->status == 'active' ? true : false;

            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_keyword = $request->meta_keyword;
            $product->meta_keyphrase = $request->meta_keyphrase;

            $product->overview = $request->only('payment_mode', 'size', 'brand', 'colors', 'country_of_origin', 'warranty', 'feature', 'use', 'gender', 'age_group');

            if ($request->hasFile('image')) {
                if ($product->image) {
                    $thumbPath = public_path('images/thumbnail');
                    $listingPath = public_path('images/listing');
                    if ((file_exists($thumbPath . '/' . $product->image)) && (file_exists($listingPath . '/' . $product->image))) {
                        unlink($thumbPath . '/' . $product->image);
                        unlink($listingPath . '/' . $product->image);
                    }
                }
                $image = $this->imageProcessing('img-', $request->file('image'));
                $product->image = $image;
            }

            $product->update();

            if (count($product->ranges)) {
                $product->ranges()->delete();
            }

            foreach ($request->from as $key => $val) {
                if (!empty($val)) {
                    $range = new Range();
                    $range->product_id = $product->id;
                    $range->from = $val;
                    $range->to = $request->to[$key] ?? null;
                    $range->price = $request->prices[$key];
                    $range->save();
                }
            }
            DB::commit();

            return response()->json([
                'status' => 'successful',
                "data" => $product,
                "message" => "Product updated successfully."
            ], 200);
        } catch (\Exception $exception) {
            DB::rollback();
            return response([
                'status' => 'unsuccessful',
                'message' => $exception->getMessage()
            ], 500);
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
        return true;
    }
}
