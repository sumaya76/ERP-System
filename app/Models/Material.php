<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $fillable = ['sku', 'name', 'category', 'unit', 'reorder_level', 'is_active'];

    protected $casts = [
        'reorder_level' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function requestItems(): HasMany
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }

    public function getOnHandAttribute(): float
    {
        return (float) $this->transactions()
            ->selectRaw("COALESCE(SUM(CASE WHEN type IN ('receipt', 'return') THEN quantity WHEN type = 'issue' THEN -quantity ELSE 0 END), 0) as balance")
            ->value('balance');
    }

    public function getAverageUnitCostAttribute(): float
    {
        $receipts = $this->transactions()->where('type', 'receipt')->whereNotNull('unit_cost');
        $quantity = (float) (clone $receipts)->sum('quantity');

        return $quantity > 0
            ? (float) (clone $receipts)->selectRaw('SUM(quantity * unit_cost) as value')->value('value') / $quantity
            : 0.0;
    }
}
