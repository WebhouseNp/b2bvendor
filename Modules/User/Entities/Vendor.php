<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use  Modules\Order\Entities\Order;
use  Modules\Product\Entities\Product;
use App\Models\User;

class Vendor extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function imageUrl($size = null)
    {
        // return "https://picsum.photos/400";

        if ($size == 'thumbnail') {
            return asset('images/thumbnail/' . $this->image);
        }

        return asset('images/listing/' . $this->image);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'vendor_id');
    }
    
    public function products(){
        return $this->hasMany(Product::class,'vendor_id');
    }
    
}
