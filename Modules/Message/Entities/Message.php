<?php

namespace Modules\Message\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\Vendor;
use DB;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // protected $appends = ['opponent'];

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiverUser()
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }

    public function getOpponentAttribute()
    {
        $user = auth()->user();
        $vendor = Vendor::where('user_id', $user->id)->where('status', 1)->first();
        $type = $vendor ? 'vendor' : 'user';
        $opponentId = 0;
        if ($type == 'vendor') {
            $opponentId = $this->from == $vendor->id ? $this->to : $this->from;
            $opponent = User::find($opponentId);

            return
                (object)['id' => $opponent->id, 'name' => $opponent->name, 'type' => 'user'];
        } else {
            $opponentId = $this->from == $user->id ? $this->to : $this->from;
            $opponent = Vendor::find($opponentId);
            return
                (object)['id' => $opponent->id, 'name' => $opponent->shop_name, 'type' => 'vendor'];
        }
    }

}
