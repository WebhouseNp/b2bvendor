<?php

namespace Modules\Deal\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Deal\Entities\Deal;
use Modules\Product\Entities\Product;

class DealProduct extends Model
{

    protected $guarded = ['id','created_at','updated_at'];

    public function deal(){
		  return $this->belongsTo(Deal::class,'deal_id');
	  }
    public function product_info (){
      return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
