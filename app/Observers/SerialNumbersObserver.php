<?php

namespace App\Observers;

use App\Models\SerialNumber;
use App\Support\CacheRegenerator;
use Illuminate\Database\Eloquent\Model;

class SerialNumbersObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the SerialNumber "saved" event.
     *
     * @param SerialNumber $serial_number
     * @return void
     */
    public function saved(SerialNumber $serial_number)
    {
        // When serial number is saved, invalidate subject Cache!
        CacheRegenerator::forgetModel($serial_number->subject_type, $serial_number->subject_id);
    }
}
