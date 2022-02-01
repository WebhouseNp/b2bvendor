<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Vendor;
use Modules\Role\Entities\Role_user;
use Modules\Role\Entities\Role;
use Modules\User\Entities\VendorPayment;
use App\Models\User;

class VendorManagementController extends Controller
{
    public function __construct(){
        $role = Role::where('slug','vendor')->first();
        $role_user = Role_user::where('role_id',$role->id)->pluck('user_id');
        $this->role_user = $role_user;
    }

    public function getApprovedVendors(){
        $users = User::whereIn('id',$this->role_user)->published()->approved()->ordered()->get();
        return view('user::vendors-list',compact('users'));
    }

    public function getSuspendedVendors(){
        $users = User::whereIn('id',$this->role_user)->published()->suspended()->ordered()->get();
        return view('user::vendors-list',compact('users'));
    }

    public function getNewVendors(){
        $users = User::whereIn('id',$this->role_user)->published()->new()->ordered()->get();
        return view('user::vendors-list',compact('users'));
    }

    public function getVendorProfile(Request $request, $username){
        $user = User::where('username',$username)->with('vendor')->first();
        return view('user::profile',compact('user'));
    }

    public function getVendorProducts(Request $request, $username){
        $user = User::where('username',$username)->with('products')->first();
        return view('user::vendorproducts',compact('user'));
    }

    public function getReport(Request $request,$id){
        $paid = VendorPayment::where('user_id',$id)->get();
        return view('user::payment',compact('paid'));
    }
    
}
