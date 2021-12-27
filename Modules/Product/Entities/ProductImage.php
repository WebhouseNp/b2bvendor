<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
