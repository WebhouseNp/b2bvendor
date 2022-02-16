<?php

namespace Modules\Review\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
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
    public function createReview(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'name'             => 'required|string',
                'reviews'          => 'required|string',
                'customer_id'       => 'required|numeric|exists:users,id',
                'product_id'       => 'required|numeric|exists:products,id',
                'rate'             => 'required|numeric'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()],422);
                exit;
            }
            $formData = $request->all();
            $orders = Order::where('user_id',$request->customer_id)->with('orderList')->pluck('id');
            $users = DB::table('order_lists')
            ->whereIn('order_id', $orders)
            ->where('product_id',$request->product_id)
            
            ->get();
            dd($users);
            $data = Review::create($formData);
            return response()->json([
                "message" => "Review created!!"
              ], 200);
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
        return view('review::index',compact('reviews'));
    }

    public function productReview($id){
        $reviews = Review::where('product_id', $id)->with('user','product')->get();
        return new ReviewCollection($reviews);
    }
   
}
