<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Modules\Message\Entities\Message;
use  Modules\User\Entities\Vendor;
use  Modules\User\Entities\Profile;
use  Modules\User\Entities\VendorPayment;
use  Modules\Product\Entities\Product;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'activation_link',
        'username',
        'publish',
        'verified',
        'otp',
        'phone_num',
        'access_level',
        'vendor_type',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('Modules\Role\Entities\Role', 'role_user', 'user_id', 'role_id');
    }

    public function vendor()
    {
        return $this->hasOne(vendor::class, 'user_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }
    public function orders()
    {
        return $this->belongsTo('Modules\Order\Entities\Order', 'user_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function vendor_payments()
    {
        return $this->hasMany(VendorPayment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('publish', 1);
    }

    public function scopeApproved($query)
    {
        return $query->where('vendor_type', 'approved');
    }

    public function scopeSuspended($query)
    {
        return $query->where('vendor_type', 'suspended');
    }

    public function scopeNew($query)
    {
        return $query->where('vendor_type', 'new');
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }
    

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

}
