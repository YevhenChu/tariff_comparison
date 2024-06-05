<?php

namespace App\Services\TariffProvider\Api\Exceptions;

use Exception;
use Throwable;

/**
 * @codeCoverageIgnore
 */
class TariffProviderRequestError extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
