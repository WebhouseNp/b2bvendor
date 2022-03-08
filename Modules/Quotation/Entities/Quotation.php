<?php

namespace Modules\Quotation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\Vendor;

class Quotation extends Model
{
    use HasFactory;

    protected $guarded = ['id','created_at','updated_at'];
    
    protected static function newFactory()
    {
        return \Modules\Quotation\Database\factories\QuotationFactory::new();
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class);
    }
}
