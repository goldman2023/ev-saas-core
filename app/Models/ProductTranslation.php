<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
//    use Cachable;
    protected $fillable = ['product_id', 'name', 'lang', 'description', 'excerpt', 'meta_title', 'meta_description'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
