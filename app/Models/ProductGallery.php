<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cloudinary\Cloudinary;

class ProductGallery extends Model
{
    protected $fillable = [
        'product_id',
        'image_url',
        'public_id',
        'position',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->public_id) {
            $cloudinary = new Cloudinary();
            return $cloudinary->image($this->public_id)->toUrl();
        }
        return $this->attributes['image_url'] ?? asset('images/default-gallery.jpg');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
