<?php

namespace Modules\Front\Http\Controllers;

use App\Service\EsewaService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Order;

class PaymentController extends Controller
{
    public function esewaSuccess(Request $request, EsewaService $esewaService)
    {
        $order = Order::findOrFail($request->oid);

        $data = [
            'amt' => $order->total_price,
            'rid' => $request->refId,
            'pid' => $order->id,
        ];

        if ($esewaService->verifyPayment($data)) {
            $order->update([
                'payment_status' => 'paid',
                'payment_type' => 'esewa',
                'esewa_ref_id' => $request->refId
            ]);
            return redirect(config('constants.customer_app_url') . '/my-orders');
        }

        return 'payment failed';
    }

    public function esewaFailed(Request $request)
    {
        return ' Esewa failed';
    }
}
