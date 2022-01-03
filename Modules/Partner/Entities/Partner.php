<?php

namespace Modules\Partner\Entities;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
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

    public function imageUrl()
    {
        return Storage::disk('public')->url($this->path);
        // return storage_publicurl($this->path);
    }

    public function deleteImage()
    {
        return Storage::delete($this->path);
    }

    public function scopePublished($query, $status = true)
    {
        return $query->where('publish', $status ? 1 : 0);
    }
    
    
}
