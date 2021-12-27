<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use  Modules\Product\Entities\Product;
use  Modules\User\Entities\Vendor;
use Modules\Order\Entities\OrderList;
use  App\Models\User;


class Order extends Model
{

    protected $guarded = ['id','created_at','updated_at'];

    public function products (){
		return $this->hasMany(Product::class, 'id', 'product_id');
	}
	public function user (){
		return $this->hasOne(User::class, 'id', 'user_id');

	}
	public function vendors (){
		return $this->hasMany(Vendor::class, 'id', 'vendor_id');
	}
	public function order_list(){
		return $this->hasMany(OrderList::class,'order_id');
	}
    
}
