<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Currency
 */
class Currency extends Model
{
    use Cachable;

    protected $fillable = ['name', 'symbol', 'status', 'code', 'created_at', 'updated_at'];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected $with = ['fx_rates'];

    protected static function boot()
    {
        parent::boot();

        // // Determine scope based on user role
        // // If admin: select currencies that are both published and not published
        // // If vendor/user: select currencies which are published
        // if(!auth()->check() || (auth()->check() && !auth()->user()->isAdmin())) {
        //     static::addGlobalScope('status', function (Builder $builder) {
        //         $builder->where('status', 1);
        //     });
        // }
    }

    public function fx_rates() {
        return $this->hasMany(CurrencyRate::class, 'base_currency_id');
    }
}
