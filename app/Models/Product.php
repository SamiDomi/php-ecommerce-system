<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'price_cents', 'stock', 'image_url', 'is_active'];

    protected function casts(): array
    {
        return ['price_cents' => 'integer', 'stock' => 'integer', 'is_active' => 'boolean'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function formattedPrice(): string
    {
        return number_format($this->price_cents / 100, 2);
    }
}
