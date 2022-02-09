<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CurrencyRate
 */
class CurrencyRate extends Model
{
    protected $table = 'currency_rates';

    protected $fillable = ['base_currency_id', 'base', 'target', 'fx_rate', 'created_at', 'updated_at'];

    protected $dateFormat = 'U';

    protected $casts = [
        'status' => 'boolean',
    ];

    public function base_currency() {
        return $this->belongsTo(Currency::class, 'base_currency_id');
    }
}
