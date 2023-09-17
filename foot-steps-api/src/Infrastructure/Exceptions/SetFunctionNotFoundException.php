<?php

declare(strict_types=1);

namespace Infrastructure\Exceptions;

use Exception;
use Throwable;

/**
 * Class SetFunctionNotFoundException
 * @package Infrastructure\Exceptions
 */
class SetFunctionNotFoundException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
