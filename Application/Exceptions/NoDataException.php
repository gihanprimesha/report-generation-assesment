<?php

/**
 * Created by VS code.
 * User: Gihan Primesha
 * Date: 06/05/21
 * Time: 11:50 PM
 */

namespace Application\Exceptions;

use \Exception;

class NoDataException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
