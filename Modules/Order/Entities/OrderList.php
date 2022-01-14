<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\Order;
use Modules\Product\Entities\Product;
use Modules\User\Entities\Vendor;

class OrderList extends Model
{
	protected $guarded = ['id', 'created_at', 'updated_at'];

	public function order()
	{
		return $this->belongsTo(Order::class, 'order_id');
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id');
	}

	public function vendor()
	{
		return $this->belongsTo(Vendor::class, 'vendor_user_id');
	}
}
