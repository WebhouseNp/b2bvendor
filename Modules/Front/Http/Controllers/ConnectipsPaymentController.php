<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Entities\Order;
use YubarajShrestha\NCHL\Facades\Nchl;

class ConnectipsPaymentController extends Controller
{
    public function setupPayment(Order $order)
    {
        $nchl = Nchl::__init([
            "txn_id" => $order->id,
            "txn_date" => date('d-m-Y'),
            "txn_amount" => $order->total_price * 100,
            "reference_id" => 'ORD-' . $order->id,
            "remarks" => 'Order #' . $order->id,
            "particulars" => 'Order #' . $order->id,
        ]);

        return response()->json([
            'gateway_url' => $nchl->core->gatewayUrl(),
            'merchant_id' => $nchl->core->getMerchantId(),
            'app_id' => $nchl->core->getAppId(),
            'app_name' => $nchl->core->getAppName(),
            'txn_id' => $nchl->core->getTxnId(),
            'txn_date' => $nchl->core->getTxnDate(),
            'txn_crncy' => $nchl->core->getCurrency(),
            'txn_amt' => $nchl->core->getTxnAmount(),
            'reference_id' => $nchl->core->getReferenceId(),
            'remarks' => $nchl->core->getRemarks(),
            'particulars' => $nchl->core->getParticulars(),
            'token' => $nchl->core->token()
        ], 200);
    }

    public function success(Request $request)
    {
        return 'Payment Successfully';
    }

    public function failed(Request $request)
    {
        return 'Payment Failed';
    }
}
