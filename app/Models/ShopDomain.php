<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class ShopDomain extends Model
{
    use Cachable;
    use Notifiable;

    protected $table = 'shop_domains';

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

}
