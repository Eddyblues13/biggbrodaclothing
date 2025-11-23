<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_slug',
        'product_image',
        'price',
        'quantity',
        'size',
        'color',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    protected $appends = [
        'formatted_price',
        'formatted_subtotal',
    ];

    /**
     * Relationships
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessors & Mutators
     */
    protected function subtotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->price * $this->quantity,
        );
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => '₦ ' . number_format($this->price, 2),
        );
    }

    protected function formattedSubtotal(): Attribute
    {
        return Attribute::make(
            get: fn () => '₦ ' . number_format($this->subtotal, 2),
        );
    }

    /**
     * Scopes
     */
    public function scopeForOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Business Logic Methods
     */
    public function getProductDetails()
    {
        return [
            'name' => $this->product_name,
            'slug' => $this->product_slug,
            'image' => $this->product_image,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'size' => $this->size,
            'color' => $this->color,
            'subtotal' => $this->subtotal,
        ];
    }

    /**
     * Check if item can be updated
     */
    public function canBeUpdated(): bool
    {
        return $this->order->isPending() || $this->order->isProcessing();
    }

    /**
     * Update item quantity with validation
     */
    public function updateQuantity(int $quantity): bool
    {
        if ($quantity <= 0) {
            return false;
        }

        if (!$this->canBeUpdated()) {
            return false;
        }

        return $this->update(['quantity' => $quantity]);
    }
}