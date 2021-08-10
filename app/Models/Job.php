<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AttributeTrait;
use App\Traits\GalleryTrait;

class Job extends Model
{
    use HasFactory;
    use AttributeTrait;
    use GalleryTrait;

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
