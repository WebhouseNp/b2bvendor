<?php

namespace Modules\Front\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->full_name,
            'email' => $this->email,
            'mobile_num' => $this->mobile_num,
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'publish' => $this->publish,
            'image' => $this->image,
            'image_url' => $this->imageUrl(),
            'image_url_thumbnail' => $this->imageUrl('thumbnail'),
            'user' => $this->whenLoaded('user'),
        ];
    }
}
