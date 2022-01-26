<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\PackageFactory::new();
    }

    public function syncTotalPrice()
    {
        return $this->update([
            'total_price' => $this->orderLists->sum('total_price'),
        ]);
    }

    public function orderLists()
    {
        return $this->hasMany(OrderList::class);
    }
}
