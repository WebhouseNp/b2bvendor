<?php

namespace Modules\Deal\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'vendor_user_id' => $this->vendor_user_id,
            'expire_at' => $this->expire_at,
            'completed_at' => $this->completed_at,
            'total_price' => $this->totalPrice(),
            'deal_products' => $this->formattedDealProducts(),
        ];
    }

    protected function formattedDealProducts()
    {
        return $this->dealProducts->map(function ($dealProduct) {
            return [
                'id' => $dealProduct->id,
                'product_id' => $dealProduct->product_id,
                'product_qty' => (int) $dealProduct->product_qty,
                'unit_price' => (int) $dealProduct->unit_price,
                'total_price' =>  $dealProduct->totalPrice(),
                'title' => $dealProduct->product ? $dealProduct->product->title : 'N/A',
            ];
        });
    }
}
