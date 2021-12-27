<?php

namespace Modules\Message\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'chat_room_id' => $this->chat_room_id,
            'sender_id' => $this->sender_id,
            'message' => $this->message,
            'read_at' => $this->read_at,
            'type' => $this->type,
            'created_at' => $this->created_at,
        ];
    }
}
