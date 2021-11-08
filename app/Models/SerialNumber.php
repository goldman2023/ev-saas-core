<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerialNumber extends Model
{
    use SoftDeletes;

    /*
     * $status can be:
     * 1. `in_stock` - means that serial number is in stock (in vendors possession)
     * 2. `out_of_stock` - serial number is out of the stock (not in possession of the vendor)
     * 3. *`reserved`* - bought by user but not yet shipped to the user (currently in vendor's stock, but reserved; when shipped it'll be out of vendor stock)
     *
     * Note: 3rd status may be used for internal vendor reports and analytics...
     */

    protected $fillable = ['subject_id', 'subject_type', 'serial_number', 'status'];
    protected $visible = ['id', 'subject_id', 'subject_type', 'serial_number', 'status', 'created_at', 'updated_at', 'deleted_at'];

    public function subject() {
        return $this->morphTo('subject');
    }
}
