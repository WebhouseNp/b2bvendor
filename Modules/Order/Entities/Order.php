<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use  Modules\Product\Entities\Product;
use  Modules\User\Entities\Vendor;
use Modules\Order\Entities\OrderList;
use  App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Entities\Address;

class Order extends Model
{
	protected $guarded = ['id', 'created_at', 'updated_at'];

	protected static function booted()
	{
		static::addGlobalScope(function (Builder $builder) {
			// filter order for vendor
			// $builder->when(auth()->check() && auth()->user()->hasRole('vendor'), function ($query) {
			// 	return $query->whereHas('orderList', function ($query) {
			// 		return $query->where('vendor_user_id', auth()->user()->id);
			// 	});
			// });

			$builder->when(auth()->check() && auth()->user()->hasRole('vendor'), function ($query) {
				return $query->whereHas('packages', function ($query) {
					return $query->where('vendor_user_id', auth()->user()->id);
				});
			});

			// filter order for customer
			$builder->when(auth()->check() && auth()->user()->hasRole('customer'), function ($query) {
				return $query->where('user_id', auth()->user()->id);
			});
		});
	}

	public function isPaid()
	{
		return $this->status == 'paid';
	}

	public function isDealCheckout()
	{
		return $this->deal_id;
	}

	public function isMultiPackage()
	{
		$this->loadMissing('packages');
		logger('packages count: ' . count($this->packages));
		return count($this->packages) > 1;
	}

	public function customer()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function packages()
	{
		return $this->hasMany(Package::class);
	}

	public function orderList()
	{
		return $this->hasMany(OrderList::class, 'order_id');
	}

	public function billingAddress()
	{
		return $this->morphOne(Address::class, 'addressable')->where('type', 'billing');
	}

	public function shippingAddress()
	{
		return $this->morphOne(Address::class, 'addressable')->where('type', 'shipping');
	}

	public function syncStatusFromPackages()
	{
		if ($this->status === 'pending') {
			if ($this->packages()->whereIn('status', ['processing', 'shipped', 'completed'])->count()) {
				$this->update(['status' => 'processing']);
			}
		}

		if ($this->status === 'processing') {
			if ($this->packages()->where('status', ['shipped', 'completed'])->count()) {
				$this->update(['status' => 'shipped']);
			}
		}

		if ($this->status === 'shipped') {
			if (!$this->packages()->where('status', '!=', 'completed')->count()) {
				$this->update(['status' => 'completed']);
				// also may be need to send the order completed email
			}
		}
	}
}
