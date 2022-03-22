<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreMeta extends Model
{
    use HasFactory;

    protected $table = 'core_meta';


    public function subject() {
        return $this->morphTo("subject");
    }
}
