<?php

namespace Modules\Review\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Front\Transformers\CustomerResource;
use Modules\Front\Transformers\ProductResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user' => CustomerResource::make($this->whenLoaded('user')),
            'product' => ProductResource::make($this->whenLoaded('product')),
            'reviews' => $this->reviews,
            'rate' => $this->rate
        ];
    }
}
