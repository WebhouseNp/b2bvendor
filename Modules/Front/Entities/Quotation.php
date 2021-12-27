<?php

namespace Modules\Front\Entities;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    
}
