<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function imageUrl($size = null)
    {
        if ($size == 'thumbnail' && $this->thumbnail_path) {
            return Storage::url($this->thumbnail_path);
        }

        return Storage::disk('public')->url($this->path);
    }
}
