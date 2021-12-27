<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Subcategory\Entities\Subcategory;
use Modules\ProductAttribute\Entities\CategoryAttribute;
use Modules\Product\Entities\Product;

class Category extends Model
{
    use Sluggable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'separator' => '_'
            ]
        ];
    }

    public function subcategory(){
        return $this->hasMany(Subcategory::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function attributes(){
        return $this->hasMany(CategoryAttribute::class);
    }
}
