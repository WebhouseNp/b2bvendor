<?php

namespace Modules\Review\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Order;
use Validator;
use Modules\Review\Entities\Review;
use Modules\Review\Transformers\ReviewCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'             => 'required|string',
                'reviews'          => 'required|string',
                'customer_id'       => 'required|numeric|exists:users,id',
                'product_id'       => 'required|numeric|exists:products,id',
                'rate'             => 'required|numeric'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()], 422);
                exit;
            }
            $formData = $request->all();
            $reviews = DB::table('reviews')
                ->where('product_id', $request->product_id)
                ->where('customer_id', $request->customer_id)
                ->get();
                if ($reviews->isNotEmpty()) {
                        return response()->json([
                            "message" => "You have already given review to the product!!"
                        ], 200);
                    }else{
                        $data = Review::create($formData);
                        return response()->json([
                            "message" => "Review created!!",
                            "data" => $data
                        ], 200);
                    }
            // $order_list = Order::with('orderList')
            //     ->whereHas('orderList', function (Builder $query) use ($request) {
            //         $query->where('product_id', $request->product_id);
            //     })
            //     ->get();
            // $reviews = DB::table('reviews')
            //     ->where('product_id', $request->product_id)
            //     ->where('customer_id', $request->customer_id)
            //     ->get();
            // if ($reviews->isNotEmpty()) {
            //     return response()->json([
            //         "message" => "You have already given review to the product!!"
            //     ], 200);
            // }
            // if ($order_list->isEmpty()) {
            //     return response()->json([
            //         "message" => "Review cannot be created as you have not brought the product!!"
            //     ], 200);
            // } else if ($order_list->isNotEmpty() && $reviews->isEmpty()) {
            //     $data = Review::create($formData);
            //     return response()->json([
            //         "message" => "Review created!!",
            //         "data" => $data
            //     ], 200);
            // }
        } catch (\Exception $ex) {
            Log::error('Review Created', [
                'status' => '500',
                'message' => serialize($ex->getMessage())
            ]);
            return response()->json([
                'status' => '500',
                'message' => 'Something  went wrong'
            ], 500);
        }
    }

    public function index()
    {
        $reviews = Review::get();
        return view('review::index', compact('reviews'));
    }

    public function productReview($id)
    {
        $reviews = Review::where('product_id', $id)->with('user:id,name', 'product:id,title')->get();
        return new ReviewCollection($reviews);
    }
}
