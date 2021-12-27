<?php

namespace Modules\Review\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;
use App\Models\User;

class Review extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
