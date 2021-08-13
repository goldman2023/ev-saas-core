<?php

namespace App\Exceptions;

use Exception;

/**
 * Domains cannot be updated. We can only create them and delete them. This is so that we can keep track of aliases and certificates on Ploi.
 * Feel free to get rid of this and deal with certificates in a way that works better for you.
 */
class DomainCannotBeChangedException extends Exception
{
    //
}
