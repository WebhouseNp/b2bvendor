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
    public function index()
    {
        $orders = Order::with(['orderList'])
            ->latest()
            ->paginate();

        return view('order::index', compact('orders'));
    }

    public function updateOrderStatus(Request $request)
    {
        $order = OrderList::where('id', $request->order_id)->first();
        if ($order) {
            $order['order_status'] = $request->status;
        }
        $product = $order->product;
        $user = User::where('id', auth()->user()->id)->first();
        $order_data = [
            'product_name' => $product->title,
            'status' => $request->status,
            'name' => $user->name
        ];
        $success  = $order->save();
        Mail::send('email.order-notice-status', $order_data, function ($message) use ($order, $user) {
            $message->to($user->email, 'Admin');
            $message->subject('Order Placed Notice Status for ' . 'b2b');
        });
        if ($success) {
            return response()->json(['status' => 'successful', 'message' => 'Order updated successfully.', 'data' => $order]);
        }
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
            return response()->json(['status' => true, 'message' => "Order updated Successfully.", 'data' => $order_data, 'html' => $view]);
        } else {
            return response()->json(['status' => false, 'message' => ["Sorry There was problem while updating Order status. Please Try again later."]]);
        }
    }

    public function show(Order $order)
    {
        $order->load(['orderList' => function($query) {
            // we only load the order list which belongs to logged in vendor
               $query->when(auth()->user()->hasRole('vendor'), function($query) {
                    return $query->where('vendor_user_id', auth()->id());
                });
            },
            // since orderlist is already loaded and constrained
            // it won't load order list again
            'orderList.product:id,title,slug',
            'customer:id,name,email',
            'billingAddress',
            'shippingAddress'
        ]);

        return view('order::show', compact('order'));
    }
}
