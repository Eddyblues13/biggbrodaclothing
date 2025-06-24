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
        'thumbnail_url',
        'gallery_urls',
        'is_on_sale',
        'current_price',
        'discount_percentage',
        'available_sizes',
        'available_colors'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(ProductGallery::class)->orderBy('position');
    }




    // Helper method to initialize Cloudinary (avoids constructor issues)
    protected function getCloudinaryInstance(): Cloudinary
    {
        return new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => ['secure' => true]
        ]);
    }

    // Accessors
    public function getImageUrlAttribute(): string
    {
        if (!$this->image_public_id) {
            return asset('images/default-product.jpg');
        }

        return $this->getCloudinaryInstance()
            ->image($this->image_public_id)
            ->resize(Resize::fill()->width(800)->height(1000))
            ->toUrl();
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (!$this->image_public_id) {
            return asset('images/default-product-thumb.jpg');
        }

        return $this->getCloudinaryInstance()
            ->image($this->image_public_id)
            ->resize(Resize::fill()->width(400)->height(500))
            ->toUrl();
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery)) {
            return [];
        }

        $cloudinary = $this->getCloudinaryInstance();
        return array_map(
            fn($publicId) => $cloudinary->image($publicId)
                ->resize(Resize::fill()->width(800)->height(1000))
                ->toUrl(),
            $this->gallery
        );
    }

    public function getIsOnSaleAttribute(): bool
    {
        return $this->discount_price > 0
            && $this->discount_price < $this->price;
    }

    public function getCurrentPriceAttribute(): float
    {
        return $this->is_on_sale ? $this->discount_price : $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        return $this->is_on_sale
            ? (int) round(100 - ($this->discount_price / $this->price * 100))
            : 0;
    }

    public function getAvailableSizesAttribute(): array
    {
        return $this->size ? explode(',', $this->size) : [];
    }

    public function getAvailableColorsAttribute(): array
    {
        return $this->color ? explode(',', $this->color) : [];
    }

    public static function getAvailableSizes()
    {
        return self::query()
            ->whereNotNull('size')
            ->pluck('size')
            ->flatMap(function ($item) {
                return array_map('trim', explode(',', $item));
            })
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    // Scopes
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

    public function scopeVisible($query)
    {
        return $this->scopeActive($query);
    }

    public function scopeWithMainImage($query)
    {
        return $query->with([
            'galleries' => fn($q) => $q
                ->where('is_default', true)
                ->orWhere('position', 0)
        ]);
    }

    public function scopeBestsellerOrFeatured($query)
    {
        return $query->where(
            fn($q) => $q
                ->where('is_bestseller', true)
                ->orWhere('is_featured', true)
        );
    }

    public function scopeOrderByPopularity($query)
    {
        return $query
            ->orderBy('is_bestseller', 'desc')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // In App\Models\Product
    public static function getAvailableColors()
    {
        return self::active()
            ->get()
            ->pluck('available_colors')
            ->flatten()
            ->unique()
            ->values()
            ->filter()
            ->toArray();
    }

    public static function getAvailableBrands()
    {
        return self::active()
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->distinct()
            ->pluck('brand')
            ->toArray();
    }
}
