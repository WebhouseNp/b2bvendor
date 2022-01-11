<?php

namespace Modules\Deal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Deal\Entities\Deal;
use Modules\Deal\Entities\DealProduct;
use Modules\Role\Entities\Role;
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
        $role = \Modules\Product\Entities\Product::checkUserRole(Auth::id());

        $deals = Deal::with(['deal_products.product_info', 'user', 'vendor' ])
        
            ->when($role == 'vendor', function ($query) {
                return $query->where('vendor_user_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('deal::index', compact('deals'));
    }

    public function create()
    {
        $products = Product::where('user_id', Auth::id())->select('id', 'title')->get()->map(function ($product) {
            $product['image_url'] = 'https://dummyimage.com/50/5b43c4/ffffff';
            return $product;
        });
        return view('deal::create')->with(compact('products'));
    }

    public function store(Request $request)
    {
        try {
            $deals = $request->all();
            $deals['vendor_user_id'] = $request->vendor_id;
            $data = Deal::create($deals);
            foreach ($deals['invoice_products'] as $key => $val) {
                if (!empty($val)) {
                    $deal = new DealProduct();
                    $deal->deal_id = $data->id;
                    $deal->product_id = $val['product_id']['id'];
                    $deal->product_qty = $val['product_qty'];
                    $deal->unit_price = $val['unit_price'];
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

    public function edit($id)
    {
        $products = Product::where('user_id', Auth::id())->select('id', 'title')->get();
        $users = User::where('publish', 1)->get();
        $deal = Deal::where('id', $id)->with('deal_products')->first();
        return view('deal::update')->with(compact('deal', 'products', 'users'));
    }

    public function update(Request $request, $id)
    {
        try {
            $deals = $request->all();
            $deal = Deal::findorFail($request->id);
            $success = $deal->update($deals);
            if (count($deal->deal_products)) {
                $deal->deal_products()->delete();
            }
            foreach ($deals['product_id'] as $key => $val) {
                if (!empty($val)) {
                    $deal = new DealProduct();
                    $deal->deal_id = $request->id;
                    $deal->product_id = $val;
                    $deal->product_qty = $deals['product_qty'][$key];
                    $deal->unit_price = $deals['unit_price'][$key];
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
    public function destroy(Request $request, Deal $deal)
    {
        $deal->delete();

        return response()->json([
            'status' => true, 'message' => "Deal deleted successfully."
        ], 200);
    }
}
