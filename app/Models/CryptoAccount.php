<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoAccount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'btc',
        'eth',
        'ltc',
        'xrp',
        'link',
        'bnb',
        'aave',
        'usdt',
        'xlm',
        'bch',
        'ada',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'btc' => 'float',
        'eth' => 'float',
        'ltc' => 'float',
        'xrp' => 'float',
        'link' => 'float',
        'bnb' => 'float',
        'aave' => 'float',
        'usdt' => 'float',
        'xlm' => 'float',
        'bch' => 'float',
        'ada' => 'float',
    ];

    /**
     * Get default values for crypto balances.
     *
     * @return array
     */
    public static function getDefaultBalances()
    {
        return [
            'btc' => 0.0,
            'eth' => 0.0,
            'ltc' => 0.0,
            'xrp' => 0.0,
            'link' => 0.0,
            'bnb' => 0.0,
            'aave' => 0.0,
            'usdt' => 0.0,
            'xlm' => 0.0,
            'bch' => 0.0,
            'ada' => 0.0,
        ];
    }

    /**
     * Get the user that owns the crypto account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
