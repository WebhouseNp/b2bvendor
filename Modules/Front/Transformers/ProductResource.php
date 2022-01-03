<?php

namespace Modules\Front\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    protected $withoutFields = [];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return $this->filterFields([
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'offer_id' => $this->offer_id,
            'brand_id' => $this->brand_id,
            'price' => $this->price,
            'shipping_charge' => $this->shipping_charge,
            'discount' => $this->discount,
            'moq' => $this->moq,
            'delivery_charge' => $this->delivery_charge,
            'essential' => $this->essential,
            'delivery_charge' => $this->delivery_charge,
            'essential' => $this->essential,
            'best_seller' => $this->best_seller,
            'image' => $this->image,
            'image_url' => $this->imageUrl(),
            'quantity' => $this->quantity,
            'non_approval_note' => $this->non_approval_note,
            'status' => $this->status,
            'isApproved' => $this->isApproved,
            'product_type' => $this->product_type,
            'type' => $this->type,
            'user_id' => $this->user_id,

            // can be hidden in collection
            'summary' => $this->summary,
            'highlight' => $this->highlight,
            'description' => $this->description,
            'meta_title' => $this->meta_title,
            'meta_keyword' => $this->meta_keyword,
            'meta_description' => $this->meta_description,
            'meta_keyphrase' => $this->meta_keyphrase,

            // Relationships
            // category, ranges, 
            // 'category' => new CategoryResource($this->whenLoaded($this->category))
            'category' => $this->whenLoaded('category'),
            // 'ranges' => new RangeCollection($this->whenLoaded($this->ranges))
            'ranges' => $this->whenLoaded('ranges'),
        ]);
    }

    public static function collection($resource)
    {
        return tap(new ProductCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }

    // Set the keys that are supposed to be filtered out
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }

    // Remove the filtered keys
    protected function filterFields($array)
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }
}
