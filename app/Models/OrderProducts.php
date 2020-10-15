<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProducts extends Model
{
    public $timestamps = false;

    protected $casts = [
        'cost_price' => 'float',
        'selling_price' => 'float',
        'vat' => 'float',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
