<?php

namespace App\Models;

use App\Models\Category;
use Cloudinary\Cloudinary;
use App\Models\ProductGallery;
use Cloudinary\Transformation\Resize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'brand',
        'price',
        'discount_price',
        'size',
        'color',
        'stock',
        'min_stock',
        'image',
        'image_public_id',
        'gallery',
        'is_featured',
        'is_bestseller',
        'is_new',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_new' => 'boolean',
        'gallery' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    protected $appends = [
        'image_url',
        'gallery_urls',
        'is_on_sale',
        'current_price',
        'discount_percentage'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(ProductGallery::class)->orderBy('position');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBestsellers($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('is_new', true);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_public_id) {
            return $this->cloudinary->image($this->image_public_id)
                ->resize(Resize::fill()->width(800)->height(1000))
                ->toUrl();
        }
        return asset('images/default-product.jpg');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->image_public_id) {
            return $this->cloudinary->image($this->image_public_id)
                ->resize(Resize::fill()->width(400)->height(500))
                ->toUrl();
        }
        return asset('images/default-product-thumb.jpg');
    }

    public function getGalleryUrlsAttribute()
    {
        if (empty($this->gallery)) {
            return [];
        }

        return array_map(function ($publicId) {
            return $this->cloudinary->image($publicId)
                ->resize(Resize::fill()->width(800)->height(1000))
                ->toUrl();
        }, $this->gallery);
    }

    public function getIsOnSaleAttribute(): bool
    {
        return !is_null($this->discount_price)
            && $this->discount_price > 0
            && $this->discount_price < $this->price;
    }

    public function getCurrentPriceAttribute()
    {
        return $this->is_on_sale ? $this->discount_price : $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->is_on_sale) {
            return 0;
        }
        return (int) round(100 - ($this->discount_price / $this->price * 100));
    }

    public function getAvailableSizesAttribute(): array
    {
        return $this->size ? explode(',', $this->size) : [];
    }

    public function getAvailableColorsAttribute(): array
    {
        return $this->color ? explode(',', $this->color) : [];
    }



    public function getRouteKeyName()
    {
        return 'slug';
    }

    // In your Product model (app/Models/Product.php)
    public function scopeVisible($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithMainImage($query)
    {
        return $query->with(['galleries' => function ($q) {
            $q->where('is_default', true)->orWhere('position', 0);
        }]);
    }

    public function scopeBestsellerOrFeatured($query)
    {
        return $query->where(function ($q) {
            $q->where('is_bestseller', true)
                ->orWhere('is_featured', true);
        });
    }

    public function scopeOrderByPopularity($query)
    {
        return $query->orderBy('is_bestseller', 'desc')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc');
    }
}
