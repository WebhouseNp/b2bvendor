<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\Order;
use Modules\Product\Entities\Product;
use Modules\Order\Entities\VendorOrder;
use App\Models\User;
use DB;

class OrderList extends Model
{

    protected $guarded = ['id','created_at','updated_at'];
    public function order(){
		return $this->belongsTo(Order::class,'order_id');
	}
	public function product_info (){
			return $this->hasOne(Product::class, 'id', 'product_id');
		}

	public function user (){
		return $this->hasOne(User::class);
	} 
	
	public function vendororder(){
		return $this->belongsTo(VendorOrder::class,'order_id');
	}

	public static function checkUserRole($user_id){
		$role_user = DB::table('role_user')->where('user_id',$user_id)->first();
		$role = DB::table('roles')->where('id',$role_user->role_id)->first();
		return $role->slug;
	}

	public static function checkVendor($user_id){
		$user = DB::table('users')->where('id',$user_id)->first();
		// dd($user);
		// $vendor = DB::table('vendors')->where('user_id',$user->id)->first();
		// dd($vendor);
		return $user->name;
	}
    
}
