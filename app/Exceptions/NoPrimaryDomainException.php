<?php

namespace App\Exceptions;

use Exception;

class NoPrimaryDomainException extends Exception
{
    public function __construct()
    {
        parent::__construct('Tenant has no primary domain.');
    }
}
