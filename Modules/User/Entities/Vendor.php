<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use  Modules\Order\Entities\Order;
use  Modules\Product\Entities\Product;
use Modules\Country\Entities\Country;
use App\Models\User;

class Vendor extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function imageUrl($size = null)
    {
        if(!$this->image) {
            $queryString = [
                'name' => $this->shop_name,
                'background' => 'b8daff',
                'color' => '0D8ABC',
            ];
    
            return 'https://ui-avatars.com/api/?' . http_build_query($queryString);
        }

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

    public function setProductCategoryAttribute($value)
    {
        $this->attributes['product_category'] = json_encode($value);
    }

    public function getProductCategoryAttribute($value)
    {
        return $this->attributes['product_category'] = json_decode($value);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'vendor_id');
    }
    
    public function products(){
        return $this->hasMany(Product::class,'vendor_id');
    }

    public function setProductCategoryAttribute($value)
    {
        $this->attributes['product_category'] = json_encode($value);
    }
    
}
