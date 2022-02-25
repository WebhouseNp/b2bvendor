<?php

namespace Modules\AlternativeUser\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AlternativeUser extends Model
{
    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
