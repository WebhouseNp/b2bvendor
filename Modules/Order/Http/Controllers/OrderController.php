<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator, DB;
use Auth, Mail;
use Illuminate\Support\Str;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderList;
use Modules\Order\Entities\VendorOrder;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Range;
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
            
            $orders = [];
            $vendor_list = [];
            
            $track_no = \Str::random(10);
            $quantity = 0;
            $amount = 0;
            
            foreach ($request->cart as $cart) {
                $quantity += $cart['qty'];
                $product_id = $cart['id'];
                $product = Product::where('id',$product_id)->with('ranges')->first();
                
                if($product->ranges->isEmpty()){
                    $amount += $product->price*$cart['qty'] + $product->shipping_charge;
                }
                foreach($product->ranges as $range){
                   if($range->from <= $cart['qty'] && $range->to >= $cart['qty']){
                     $amount += $range->price*$cart['qty'] + $product->shipping_charge;
                   }
                }
            }
            $order_data = [
                'user_id'   => request()->user_id,
                'quantity' => $quantity,
                'amount' => $amount,
                'city'  => $request->city,
                'address'  => $request->address,
                'phone'     => $request->phone,
                'order_note' => $request->order_note,
                'track_no' => $track_no,
                'status' => 'New',
                'delivery_charge' => 0,
                'payment_type' => $request->payment_type,
            ];
            $data = Order::create($order_data);
            foreach ($request->cart as $key => $cart_items) {
                $product_id = $cart_items['id'];
                    $product = Product::where('id',$product_id)->with('ranges')->first();
                    $user_id = $product->user_id;
                $role = \Modules\Order\Entities\OrderList::checkUserRole($user_id);
                // if($role == 'vendor'){
                //     $vendors[] = $user_id;
                // }
                // $amount = ($cart_items['quantity']*($product->price)) + $cart_items['shipping_charge'];
                if($product->ranges->isEmpty()){
                    $amount = $product->price*$cart_items['qty'] + $product->shipping_charge;
                }
                foreach($product->ranges as $range){
                   if($range->from <= $cart_items['qty'] && $range->to >= $cart_items['qty']){
                     $amount = $range->price*$cart_items['qty'] + $product->shipping_charge;
                   }
                }
                $order_list_data = [
                    'order_id'   => $data->id,
                    'customer_id'   => $request->user_id,
                    'track_no'  => $track_no,
                    'quantity' => $cart_items['qty'],
                    'amount' => $amount,
                    'product_id' => $cart_items['id'],
                    'user_id' => $user_id
                ];
                

                $order_list = OrderList::create($order_list_data);
            }
            foreach ($request->cart as $key => $cart_items) {
                $product_id = $cart_items['id'];
                    $product = Product::where('id',$product_id)->with('ranges')->first();
                    $user_id = $product->user_id;
                $role = \Modules\Order\Entities\OrderList::checkUserRole($user_id);
                if($role == 'vendor'){
                    $vendors[] = $user_id;
                    $vens = array_unique($vendors);
                    $dataForVendorTable = [];
                    foreach($vens as $vendor){
                        $dataForVendorTable[] = ['order_id'=>$data->id,'customer_id'=>$request->user_id,'user_id'=>$vendor];
                    }
                    if(count($dataForVendorTable)){
                        foreach($dataForVendorTable as $vendororder){
                            VendorOrder::create($vendororder);
                        }
                        
                    }
                    
                }
                if($role == 'vendor'){
                    $vendors[] = $user_id;
                    foreach($vens as $vendor){
                        $vendor_data = OrderList::where('order_id',$data->id)->where('user_id',$vendor)->with(['product_info'])->get();
                        $range = '';
                        foreach($vendor_data as $v){
                            $range = $v['product_info']['ranges'];
                        }
                        $vendor_data = ['vendor_data'=>$vendor_data->toArray(),'range'=>$range];
                        $user = User::where('id',$vendor)->first();
                        Mail::send('email.vendor-order-notice',$vendor_data, function ($message) use ($user) {
                            $message->to($user->email, 'Admin');
                            $message->subject('Order Placed Notice for ' . 'b2b');
                         });
                        // array_push($vendor_list,$vendor_data);
                    }
                }
            }
            // if($role == 'vendor'){
            //     $vendors[] = $user_id;
            //     $vens = array_unique($vendors);
            //     $dataForVendorTable = [];
            //     foreach($vens as $vendor){
            //         $dataForVendorTable[] = ['order_id'=>$data->id,'customer_id'=>$request->user_id,'user_id'=>$vendor];
            //     }
            //     if(count($dataForVendorTable)){
            //         foreach($dataForVendorTable as $vendororder){
            //             VendorOrder::create($vendororder);
            //         }
                    
            //     }
            // }
            
            $order_id = $data->id;
            $order_data['name'] = $data->user->name;
            $order_data['email'] = $data->user->email;
            $order_data['order_list'] = $data->order_list;
            // $vendor_list = [];
            // if($role == 'vendor'){
            //     $vendors[] = $user_id;
            //     foreach($vens as $vendor){
            //         $vendor_data = OrderList::where('order_id',$data->id)->where('user_id',$vendor)->with(['product_info'])->get();
            //         // dd($vendor_data);
            //         $range = '';
            //         foreach($vendor_data as $v){
            //             $range = $v['product_info']['ranges'];
            //         }
            //         // dd($range);
            //         $vendor_data = ['vendor_data'=>$vendor_data->toArray(),'range'=>$range];
            //         // dd($vendor_data);
            //         // foreach($vendor_data as $key=>$list){
            //         //     dd($list[0]['product_info']['ranges'][0]['from']);
            //         //     // foreach($list[1]['product_info']['ranges'] as $range){
            //         //         if($list[1]['product_info']['ranges']->from <= $list['quantity'] && $list[1]['product_info']['ranges']->to >= $list['quantity']){
            //         //             dd($list[1]['product_info']['ranges']->price);
            //         //         // }
            //         //     }
            //         // }
            //         $user = User::where('id',$vendor)->first();
            //         Mail::send('email.vendor-order-notice',$vendor_data, function ($message) use ($user) {
            //             $message->to($user->email, 'Admin');
            //             $message->subject('Order Placed Notice for ' . 'b2b');
            //          });
            //         array_push($vendor_list,$vendor_data);
            //         }
            // }
            // foreach($vens as $vendor){
            // $vendor_data = OrderList::where('order_id',$data->id)->where('user_id',$vendor)->with('product_info')->get();
            // // foreach($vendor_data as $v){
            // //     dd($v->product_info->ranges);
            // // }
            // $vendor_data = ['vendor_data'=>$vendor_data->toArray()];
            // // dd($vendor_data['product_info']);
            
            // $user = User::where('id',$vendor)->first();
            // Mail::send('email.vendor-order-notice',$vendor_data, function ($message) use ($user) {
            //     $message->to($user->email, 'Admin');
            //     $message->subject('Order Placed Notice for ' . 'b2b');
            //  });
            // array_push($vendor_list,$vendor_data);
            // }
            Mail::send('email.order-notice', $order_data, function ($message) use ($order_data) {
                $message->to($order_data['email'], 'Admin');
                $message->subject('Order Placed Notice for ' . 'b2b');
             });
            DB::commit();
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
        $orders = OrderList::where('user_id',Auth::id())->with('order')->get();
        
        return view('order::vendor-orders', compact('orders'));
        
    }

    public function updateOrderStatus(Request $request){
        $order = OrderList::where('id',$request->order_id)->with(['product_info'])->first();
        if($order){
            $order['order_status']= $request->status;
        }
        $product = $order->product_info;
        $user = User::where('id',$order->customer_id)->first();
        $order_data = [
            'product_name' => $product->title,
            'status' => $request->status,
            'name' => $user->name
        ];
        $success  = $order->save();
        Mail::send('email.order-notice-status', $order_data, function ($message) use ($order,$user) {
            $message->to($user->email, 'Admin');
            $message->subject('Order Placed Notice Status for ' . 'b2b');
         });
        if($success){
            return response()->json(['status' => 'successful', 'message' => 'Order updated successfully.', 'data' => $order]);
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
        $order = Order::where('id',$id)->with(['order_list','user','products','vendors'])->first();
        return view('order::show',compact('order'));
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
