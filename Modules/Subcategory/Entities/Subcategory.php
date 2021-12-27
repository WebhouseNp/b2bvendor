<?php

namespace Modules\Subcategory\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\ProductAttribute\Entities\CategoryAttribute;

class Subcategory extends Model
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
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function attributes(){
        return $this->hasMany(CategoryAttribute::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
