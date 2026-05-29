<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service',
        'provider',
        'customer_reference',
        'package',
        'amount',
        'balance_before',
        'balance_after',
        'reference',
        'status',
        'description',
        'meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
