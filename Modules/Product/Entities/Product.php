<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Category\Entities\Category;
use Modules\Subcategory\Entities\Subcategory;
use Modules\Product\Entities\Quantity;
use Modules\Product\Entities\Variant;
use Modules\Product\Entities\Sku;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderList;
use Modules\Offer\Entities\Offer;
use Modules\Brand\Entities\Brand;
use Modules\User\Entities\Vendor;
use Modules\Product\Entities\ProductImage;
use Modules\Product\Entities\Range;
use Modules\Review\Entities\Review;
use App\Models\User;
use Modules\Product\Entities\ProductAttributeValue;
use DB;

class Product extends Model
{
    use Sluggable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'separator' => '_'
            ]
        ];
    }

    public function imageUrl()
    {
        return asset('images/thumbnail/' . $this->image);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product_attribute_values()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function quantities()
    {
        return $this->hasMany(Quantity::class, 'product_id');
    }

    public function variants()
    {
        return $this->hasOne(Variant::class, 'product_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productimage()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function order_list()
    {
        return $this->hasOne(OrderList::class);
    }

    public function skus()
    {
        return $this->hasMany(Sku::class);
    }

    public function ranges()
    {
        return $this->hasMany(Range::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public static function checkUserRole($user_id)
    {
        $role_user = DB::table('role_user')->where('user_id', $user_id)->first();
        $role = DB::table('roles')->where('id', $role_user->role_id)->first();
        return $role->slug;
    }
}
