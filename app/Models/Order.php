<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_name', 'email', 'phone', 'address', 'city', 'postal_code', 'country',
        'subtotal_cents', 'shipping_cents', 'total_cents', 'status',
    ];

    protected function casts(): array
    {
        return ['subtotal_cents' => 'integer', 'shipping_cents' => 'integer', 'total_cents' => 'integer'];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
