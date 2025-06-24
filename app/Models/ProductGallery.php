<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;

class ProductGallery extends Model
{
    protected $fillable = [
        'product_id',
        'public_id',
        'image_url',
        'position',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // Remove 'image_url' from fillable (we'll generate URLs dynamically)
    // Keep 'public_id' as the source of truth

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    public function getImageUrlAttribute(): string
    {
        if ($this->public_id) {
            return $this->getCloudinaryInstance()
                ->image($this->public_id)
                ->resize(Resize::fill()->width(800)->height(800))
                ->toUrl();
        }

        // New fallback to product image if gallery image missing
        if ($this->product && $this->product->image_public_id) {
            return $this->product->image_url;
        }

        return asset('images/default-gallery.jpg');
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (!$this->public_id) {
            return asset('images/default-gallery-thumb.jpg');
        }

        return $this->getCloudinaryInstance()
            ->image($this->public_id)
            ->resize(Resize::fill()->width(400)->height(400))
            ->toUrl();
    }

    protected function getCloudinaryInstance(): Cloudinary
    {
        static $cloudinary; // Cache instance for performance

        if (!$cloudinary) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
                'url' => ['secure' => true]
            ]);
        }

        return $cloudinary;
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // In ProductGallery model

}
