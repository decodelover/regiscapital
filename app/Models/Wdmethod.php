<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Wdmethod extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Scope enabled methods that can be used for deposits.
     */
    public function scopeEnabledForDeposit($query)
    {
        return $query->where(function ($innerQuery) {
            $innerQuery->where('type', 'deposit')
                ->orWhere('type', 'both');
        })->where('status', 'enabled');
    }

    /**
     * Return the canonical user deposit methods:
     * Bank Transfer, Bitcoin, Ethereum, and USDT (if configured and enabled).
     */
    public static function curatedDepositMethods(): Collection
    {
        return static::curatedDepositMap()->values();
    }

    /**
     * Resolve a deposit method by ID or by exact name from curated methods only.
     */
    public static function findCuratedDepositMethod($identifier): ?self
    {
        if (is_null($identifier) || trim((string) $identifier) === '') {
            return null;
        }

        $methods = static::curatedDepositMap();

        if (is_numeric($identifier)) {
            $id = (int) $identifier;
            return $methods->first(function ($method) use ($id) {
                return (int) $method->id === $id;
            });
        }

        $needle = Str::lower(trim((string) $identifier));

        return $methods->first(function ($method) use ($needle) {
            return Str::lower((string) $method->name) === $needle;
        });
    }

    /**
     * Return available curated kinds for admin/user prompts.
     */
    public static function curatedDepositKindsStatus(): array
    {
        $map = static::curatedDepositMap();

        return [
            'bank_transfer' => !is_null($map->get('bank_transfer')),
            'bitcoin' => !is_null($map->get('bitcoin')),
            'ethereum' => !is_null($map->get('ethereum')),
            'usdt' => !is_null($map->get('usdt')),
        ];
    }

    /**
     * Internal: map configured methods to canonical kinds.
     */
    protected static function curatedDepositMap(): Collection
    {
        $methods = static::query()
            ->enabledForDeposit()
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get();

        $map = collect([
            'bank_transfer' => null,
            'bitcoin' => null,
            'ethereum' => null,
            'usdt' => null,
        ]);

        foreach ($methods as $method) {
            $kind = static::resolveKind($method);
            if (!$kind || !is_null($map->get($kind))) {
                continue;
            }
            $map->put($kind, $method);
        }

        return $map->filter();
    }

    /**
     * Detect canonical kind from method metadata.
     */
    protected static function resolveKind(self $method): ?string
    {
        $name = Str::lower((string) $method->name);
        $methodType = Str::lower((string) $method->methodtype);

        if ($methodType === 'currency' && Str::contains($name, ['bank', 'wire transfer', 'bank transfer', 'wire'])) {
            return 'bank_transfer';
        }

        if ($methodType !== 'crypto') {
            return null;
        }

        if (Str::contains($name, ['bitcoin', 'btc'])) {
            return 'bitcoin';
        }

        if (Str::contains($name, ['ethereum', 'eth'])) {
            return 'ethereum';
        }

        if (Str::contains($name, ['usdt', 'tether'])) {
            return 'usdt';
        }

        return null;
    }
}
