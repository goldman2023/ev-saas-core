<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use Cachable;
    protected $fillable = ['product_id','name', 'lang'];

    public function product(){
      return $this->belongsTo(Product::class);
    }
}
