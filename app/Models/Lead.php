<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'message'];

    use HasFactory;

    public static function trend($period = 30)
    {
        $present = self::where('created_at', '>=', Carbon::now()->subdays($period))->count();

        $past = self::where('created_at', '<=', Carbon::now()->subdays($period))->count();

        if ($present == 0) {
            $present = 1;
        }

        $percentChange = (1 - $past / $present) * 100;

        return $percentChange;
    }
}
