<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use SoftDeletes;

    protected $casts = [
        'cost_price' => 'float',
        'carriage_price' => 'float',
        'selling_price' => 'float',
        'vat' => 'float',
    ];

    protected $dates = ['ordered_at', 'invoiced_at',];

    protected static function boot ()
    {
        parent::boot();
        static::creating(function (Order $order) {
            $last = Order::orderBy('reference', 'desc')->first();
            $order->attributes['reference'] = $last ? ++$last->reference : 1;
            $order->attributes['ordered_at'] = Carbon::now();
        });

    }

    public function park(): BelongsTo
    {
        return $this->belongsTo(Park::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProducts::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('orderProducts', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })->orWhereHas('supplier', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })->orWhereHas('park', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
