<?php

namespace Modules\Deal\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Deal\Entities\DealProduct;
use Modules\Product\Entities\Product;
use App\Traits\Uuid;
use App\Models\User;
use Illuminate\Notifications\Notifiable;


class Deal extends Model
{
  Use Uuid, Notifiable;
   
    public $incrementing = false;

    protected $keyType = 'uuid';
    protected $guarded = ['id','created_at','updated_at'];

    protected $dates = ['expire_at'];

    public function deal_products(){
		  return $this->hasMany(DealProduct::class,'deal_id');
	  }

    public function products(){
		  return $this->hasMany(Product::class,'product_id');
	  }

    public function user(){
      return $this->belongsTo(User::class,'customer_id');
    }
    public function vendor(){
      return $this->belongsTo(User::class,'vendor_user_id');
    }
}


