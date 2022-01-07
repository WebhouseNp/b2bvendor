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
            'last_message_at' => $this->updated_at->diffForHumans(),
            'updated_at' => $this->updated_at,
            'opponent' => $this->opponentUser()
        ];
    }

    protected function opponentUser()
    {
        if (auth()->id() == $this->customer_user_id) {
            $vendor = $this->vendorUser;
            return [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'avatar_url' => $this->generateAvatarUrl($vendor->name)
            ];
        }

        $customer = $this->customerUser;
        return [
            'id' => $customer->id,
            'name' => $customer->name,
            'avatar_url' => $this->generateAvatarUrl($customer->name)
        ];
    }

    protected function generateAvatarUrl($name)
    {
        $queryString = [
            'name' => $name,
            'background' => '0D8ABC',
            'color' => 'fff',
            'rounded' => true
        ];

        return 'https://ui-avatars.com/api/?' . http_build_query($queryString);
    }
}
