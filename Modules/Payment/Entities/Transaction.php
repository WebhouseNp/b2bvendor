<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_cod' => 'boolean'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\TransactionFactory::new();
    }

    public function fileUrl()
    {
        return Storage::disk('public')->url($this->file);
    }
}
