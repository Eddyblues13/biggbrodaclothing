<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_active',
        'position'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Cloudinary image URL helper
    public function getImageUrlAttribute()
    {
        if ($this->image_public_id) {
            $cloudinary = new \Cloudinary\Cloudinary();
            return $cloudinary->image($this->image_public_id)->toUrl();
        }
        return asset('images/default-category.jpg');
    }
}
