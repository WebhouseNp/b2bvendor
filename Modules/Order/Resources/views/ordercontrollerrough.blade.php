<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator, DB;
use Auth;
use Illuminate\Support\Str;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderList;
use Modules\Order\Entities\VendorOrder;
use Modules\Product\Entities\Product;
use Modules\Role\Entities\Role_user;
use Modules\Role\Entities\Role;
use App\Models\User;
use Modules\User\Entities\Vendor;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('order::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('order::create');
    }

    public function createorder(Request $request){
        try{
            // dd($request->all());
            // {
            //     "user_id":1,
            //     "product_id":[1,2,3],
            //     "vendor_id":[2,3,4],
            //     "quantity":[10,8,5],
            //     "price":[400,500,600],
            //     "order_note":"fghfhfghfh",
            //     "payment_type":"esewa",
            //     "city":"fghfhfghfh",
            //     "address":"fghfhfghfh",
            //     "phone":984935874582,
            // }
            $validator = Validator::make($request->all(), [
            // 'product_id'   => 'required|numeric|exists:products,id',
            // 'vendor_id'    => 'required|numeric|exists:vendors,id',
            // 'user_id'      => 'required|numeric|exists:users,id',
            // 'phone'        => 'required',
            // 'city'         => 'required',
            // 'address'      => 'required',
            // // 'track_no'     => 'required',
            // 'order_note'   => 'required',
            // 'payment_type' => 'required|in:esewa,paypal,cash_on_delivery,tt',
            // 'status' => 'required|in:New,Verified,Cancel,Process,Delivered'
       
             ]);
             if($validator->fails()) {
                return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                exit;
            }
            DB::beginTransaction();
            // $value = $request->except('status','payment_type');
            
            // $value['track_no'] = Str::random(10);
            $orders = [];
            
            // $total_amt = 0;
            // $quantity = 0;
            // $amount = 0;
            // foreach ($request->product_id as $cart) {
            //     foreach ($request->vendor_id as $vendor) {
            //     foreach ($request->cart as $cart) {
            //         // dd($cart['quantity']);
            //         // foreach ($request->price as $price) {
            //     // dd($cart,$vendor,$quantity,$amount);
            //     $quantity += $cart['quantity'];
            //     // dd($quantity);
            //     $amount += $cart['amount'];
            //     // }
            // }
            //     }
            // }
            // dd($quantity,$amount);
            $track_no = \Str::random(10);
            $order_data = [
                'user_id'   => request()->user_id,
                // 'quantity' => $quantity,
                // 'amount' => $amount,
                'city'  => $request->city,
                'address'  => $request->address,
                'phone'     => $request->phone,
                'order_note' => $request->order_note,
                // 'google_map' => $request->google_map,
                'track_no' => $track_no,
                'status' => 'New',
                'delivery_charge' => 0,
                'payment_type' => $request->payment_type,
            ];
            // dd($order_data);
            $data = Order::create($order_data);
            // dd($order_id);
            // dd($data->id);
            foreach ($request->cart as $key => $cart_items) {
                // dd($cart_items['product_id']);
                $product_id = $cart_items['product_id'];
                    $product = Product::where('id',$product_id)->first();
                    $user_id = $product->user_id;
                $role = \Modules\Order\Entities\OrderList::checkUserRole($user_id);
                $order_list_data = [
                    'order_id'   => $data->id,
                    'customer_id'   => $request->user_id,
                    'track_no'  => $track_no,
                    'quantity' => $cart_items['quantity'],
                    'amount' => $cart_items['amount'],
                    'product_id' => $cart_items['product_id'],
                    'user_id' => $user_id
                ];
                

               if($role == 'vendor'){
                $vendor_data = [
                    'order_id'   => $data->id,
                    'customer_id'   => $request->user_id,
                    'track_no'  => $track_no,
                    'quantity' => $cart_items['quantity'],
                    'amount' => $cart_items['amount'],
                    'product_id' => $cart_items['product_id'],
                    'user_id' => $user_id
                ];
                $vendor_list_data = VendorOrder::create($vendor_data);
               }
                
                $order_list = OrderList::create($order_list_data);
                // $vendor_list_data = VendorOrder::create($vendor_data);
                // $order_list->fill($order_list_data);
                // $order_list->save();
                DB::commit();
            }
            // dd($order_list);
            // $order_data['order_id'] = $order_id->id;
            // $order_data['order_list'] = $order_id->order_list;
            // $order_data['amount'] = $order_id->amount;
            // $orders = $order_data['order_list'];
            // dd($orders);
            // foreach ($orders as $cart_key => $cart_data) {
            //     $total_amt += $cart_data->amount * $cart_data->quantity;
            // }

                // $product_data = Product::where('id',$product)->first();
                // $order              = new Order();
                // $order->product_id = $product;
                // $order->amount = $product_data->price;
                // $order->user_id = $request->user_id;
                // $order->city = $request->city;
                // $order->order_note = $request->order_note;
                // $order->phone = $request->phone;
                // $order->address = $request->address;
                // $order->payment_type = $request->payment_type;
                // $order->status = $request->status;
                // $order->track_no = Str::random(10);

                // // foreach ($request->amount as $amount) 
                // // $order->amount = $amount;
                // $order->save();
            
                // $document->sentToApprovers()->sync([$approve->id],false);
            // }
            // 
            if($data){
                return response()->json(['status' => 'successful', 'message' => 'Order created successfully.', 'data' => $data]);

            }

        } catch(\Exception $exception){
              return response([
                  'message' => $exception->getMessage()
              ],400);
          }
    }

    public function getVendorOrders(){
        try{
        $order_list_products = OrderList::pluck('product_id');
        $order_list = OrderList::pluck('quantity');
        $product = Product::whereIn('id',$order_list_products)->where('user_id',Auth::id())->get();
        if($product){
            return response()->json(['status' => 'successful', 'message' => 'Vendor Order retrieved successfully.', 'data' => $product]);
        }
        } catch(\Exception $exception)
            {
                return response([
                    'message' => $exception->getMessage()
                ],400);
            }
    }

    public function getorders(){
        $orders = Order::orderBy('created_at', 'desc')->with('order_list')->get();
        // $o = [];
        // foreach($orders as $order){
        //     foreach($order->order_list as $order_list){
        //         array_push($o,$order_list);
        //     }
        // }
        
        // dd($o);
        // dd($orders->order_list);
        $view = \View::make("order::ordersTable")->with('orders', $orders)->render();
        return response()->json(['html' => $view, 'status' => 'successful', 'data' => $orders]);
    }

    public function changeOrderStatus(Request $request)
        {
            $data = $request->all();
            $validation = Validator::make($data, [
                'order_id'      => 'required|numeric|exists:orders,id',
                'status'          => 'required',
            ]);
    
    
            if ($validation->fails()) {
                foreach ($validation->messages()->getMessages() as $message) {
                    $errors[] = $message;
                }
                return response()->json(['status' => false, 'message' => $errors]);
            }
            $order = Order::find($request->order_id);
            $orders = Order::orderBy('created_at', 'desc')->get();
            if (!$order) {
                return response()->json(['status' => false, 'message' => ['Invalid Order id or order not found.']]);
            }
            // if ($request->status == 'verified' || $request->status == 'process' || $request->status == 'delivered' || $request->status == 'cancel') {
            //     $data['status'] = 'new';
            // }
            // dd($data['status']);
            if ($request->status == 'New') {
                $data['status'] = 'process';
            }
            if ($request->status == 'Process') {
                $data['status'] = 'verified';
            }
            if ($request->status == 'Verified') {
                $data['status'] = 'delivered';
            }
            if ($request->status == 'Delivered') {
                $data['status'] = 'cancel';
            }
            if ($request->status == 'Cancel') {
                $data['status'] = 'new';
            }
            
            $order->update($data);
            $success = $order->save();
            if ($success) {
                $order_data = $order->where(['id' => $request->order_id])->get();
                $orders = Order::orderBy('created_at', 'desc')->get();
                $view = \View::make("order::ordersTable")->with('orders', $orders)->render();
                return response()->json(['status' => true, 'message' => "Order updated Successfully.", 'data' => $order_data ,'html' => $view]);
            } else {
                return response()->json(['status' => false, 'message' => ["Sorry There was problem while updating Order status. Please Try again later."]]);
            }
        }

        public function editorder(Request $request)
    {
        // $order = Order::where('id',$request->id)->with(['order_list','user','products','vendors'])->first();
        // return view('Order::create',compact('order'));
    //     try{
    //         $order = Order::where('id',$request->id)->with(['order_list','user','products','vendors'])->first();
    //         // dd($order);
    //         // dd($order->order_list->product_info);
    //         // $o = [];
    //         // foreach($order->order_list as $order_list){
    //         //         // dd($order_list->product_info);
    //         //         array_push($o,$order_list->product_info);
    //         // }
    //         // dd($o);
    //         // dd(unserialize($orders->product_details));
    //         // dd(explode('"',$orders->product_details));
    //         // foreach($orders->product_details as $product_detail){

    //         // }
    //   return response()->json([
    //     "data" => $order
    //   ], 200);
    //     } catch(\Exception $exception){
    //         return response([
    //             'message' => $exception->getMessage()
    //         ],400);
    //     }

    }

    public function updateorder(Request $request)
	{
        try{
            $order = Order::findOrFail($request->id);
            $validator = Validator::make($request->all(), [
                // 'status' => 'required|in:New,Verified,Cancel,Process,Delivered'
           
                 ]);
                 if($validator->fails()) {
                    return response()->json(['status' => 'unsuccessful', 'data' => $validator->messages()]);
                    exit;
                }
                $data['status'] = $request->status;
		$order->update($data);
      return response()->json([
        "data" => $order,
        "status" => 'successful',
        "message" => 'Order Status Updated Successfully!!'
      ], 200);
        } catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
		
	}

    

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('order::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // dd($id);
        $order = Order::where('id',$id)->with(['order_list','user','products','vendors'])->first();
        // dd($order);
        return view('order::create',compact('order'));
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
