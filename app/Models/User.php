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
use Modules\User\Entities\Address;


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
        'api_token',
        'birthday',
        'gender',
        'image',
        'designation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['roles'];

    public function hasRole($role)
    {
        $roles =  auth()->user()->roles->pluck('slug')->all();
        return in_array($role, $roles);
    }

    public function hasAnyRole($roles)
    {
        if (!is_array($roles)) {
            $roles = explode('|', $roles);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }

        return false;
    }

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

    public function scopeVerified($query)
    {
        return $query->where('verified', 1);
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

    public function imageUrl($size = null)
    {
        if (!$this->image) {
            $queryString = [
                'name' => $this->name,
                'background' => 'b8daff',
                'color' => '0D8ABC',
            ];

            return 'https://ui-avatars.com/api/?' . http_build_query($queryString);
        }

        if ($size == 'thumbnail') {
            return asset('images/thumbnail/' . $this->image);
        }

        return asset('images/listing/' . $this->image);
    }
}
