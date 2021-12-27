<?php

namespace Modules\Review\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator;
use Modules\Review\Entities\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function createReview(Request $request){
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'name'             => 'required|string',
                'reviews'          => 'required|string',
                'customer_id'       => 'required|numeric|exists:users,id',
                'product_id'       => 'required|numeric|exists:products,id',
                'rate'             => 'required|numeric'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            $formData = $request->all();
            $data = Review::create($formData);
            return response()->json([
                "message" => "Review created!!"
              ], 201);
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

   

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('review::create');
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
        return view('review::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('review::edit');
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
}
