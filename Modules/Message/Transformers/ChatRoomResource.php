<?php

namespace Modules\Message\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomResource extends JsonResource
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
            'customer_user_id' => $this->customer_user_id,
            'vendor_user_id' => $this->vendor_user_id,
            'last_message_at' => $this->last_message_at,
            'vendor_name' => 'Vendor',
            'customer_name' => 'John Doe',
        ];
    }
}
