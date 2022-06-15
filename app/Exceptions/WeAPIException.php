<?php

namespace App\Exceptions;

use Exception;

class WeAPIException extends Exception
{
    public $message;
    public $type;
    public $code;

    public function __construct($message = '', $type = '', $code = '') {
        $this->message = $message;
        $this->type = $type;
        $this->code = $code;
    }
}
