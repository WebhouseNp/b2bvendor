<?php

namespace Modules\Deal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Deal\Entities\Deal;
use Modules\Deal\Entities\DealProduct;
use Modules\Role\Entities\Role ;
use Modules\User\Entities\Vendor;
use Auth;
use App\Models\User;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $role= \Modules\Product\Entities\Product::checkUserRole(Auth::id());
        $deals = Deal::with(['deal_products','user'])
        ->when($role == 'super_admin' && $role == 'admin' , function($query) {
            return $query->get();
        })
        ->when($role == 'vendor' , function($query) {
            return $query->where('vendor_user_id', auth()->id());
        })
        ->get();
        return view('deal::index',compact('deals'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $products = Product::where('user_id',Auth::id())->select('id','title')->get();
        $users = User::where('publish',1)->get();
        return view('deal::create',compact('products','users'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $deals = $request->all();
            $deals['vendor_user_id'] = auth()->id();
            $data = Deal::create($deals);
            foreach($deals['product_id'] as $key=>$val){
                if(!empty($val)){
                    $deal = new DealProduct();
                    $deal->deal_id = $data->id;
                    $deal->product_id = $val;
                    $deal->product_qty = $deals['product_qty'][$key];
                    $deal->unit_price= $deals['unit_price'][$key];
                    $deal->save();
                }
            }
        return response()->json(['status' => 'successful', 'message' => 'Deal created successfully.', 'data' => $deal]);
 
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('deal::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try{
            $deal = Deal::where('id',$id)->with('deal_products')->first();
            return response()->json(['status' => 'successful', 'message' => 'Deal displayed.', 'data' => $deal]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
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
        try{
            $deals = $request->all();
            $deal = Deal::findorFail($request->id);
            $success = $deal->update($deals);
            if(count($deal->deal_products)){
                $deal->deal_products()->delete();
    
            }
            foreach($deals['product_id'] as $key=>$val){
                if(!empty($val)){
                    $deal = new DealProduct();
                    $deal->deal_id = $request->id;
                    $deal->product_id = $val;
                    $deal->product_qty = $deals['product_qty'][$key];
                    $deal->unit_price= $deals['unit_price'][$key];
                    $deal->save();
                }
            }
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        try {
            $deal = Deal::findorFail($request->id);
            $deal->delete();
            return response()->json([
                'status' => true, 'message' => "Deal deleted successfully."
            ],200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        
    }
}
