<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_order',
        'max_discount',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
        'applicable_to',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'applicable_to' => 'array',
    ];

    /**
     * Get promo usages.
     */
    public function usages(): HasMany
    {
        return $this->hasMany(PromoUsage::class);
    }

    /**
     * Scope for active promos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for valid promos (active and within date range).
     */
    public function scopeValid($query)
    {
        $today = Carbon::today();
        return $query->active()
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today);
    }

    /**
     * Check if promo is currently valid.
     */
    public function isValid(): bool
    {
        $today = Carbon::today();
        return $this->is_active
            && $this->start_date <= $today
            && $this->end_date >= $today;
    }

    /**
     * Check if promo can be used (within usage limits).
     */
    public function canBeUsed(?int $userId = null): bool
    {
        // Check if valid
        if (!$this->isValid()) {
            return false;
        }

        // Check global usage limit
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        // Check per-user limit
        if ($userId && $this->usage_limit_per_user > 0) {
            $userUsageCount = $this->usages()->where('user_id', $userId)->count();
            if ($userUsageCount >= $this->usage_limit_per_user) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if promo is applicable to a specific type.
     */
    public function isApplicableTo(string $type): bool
    {
        // If applicable_to is null or empty, it applies to everything
        if (empty($this->applicable_to)) {
            return true;
        }

        return in_array($type, $this->applicable_to);
    }

    /**
     * Calculate discount amount.
     */
    public function calculateDiscount(float $orderAmount): float
    {
        // Check minimum order
        if ($orderAmount < $this->min_order) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = $orderAmount * ($this->value / 100);
            
            // Apply max discount cap if set
            if ($this->max_discount !== null && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
        } else {
            // Fixed amount
            $discount = min($this->value, $orderAmount);
        }

        return round($discount, 2);
    }

    /**
     * Get formatted discount value for display.
     */
    public function getFormattedValueAttribute(): string
    {
        if ($this->type === 'percentage') {
            return $this->value . '%';
        }
        return 'Rp ' . number_format($this->value, 0, ',', '.');
    }

    /**
     * Get remaining usage count.
     */
    public function getRemainingUsageAttribute(): ?int
    {
        if ($this->usage_limit === null) {
            return null; // Unlimited
        }
        return max(0, $this->usage_limit - $this->used_count);
    }

    /**
     * Increment usage count.
     */
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }
}
