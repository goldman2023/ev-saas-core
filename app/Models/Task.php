<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    public function creator(){

        return $this->belongsTo(User::class, 'foreign_key');
    }

    public function assigne(){
        return $this->belongsTo(User::class, 'foreign_key');
    }
   
    public function subject(){
        return $this->morphTo('subject');
    }
}
