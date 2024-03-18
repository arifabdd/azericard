<?php

namespace ArifAbdd\Azericard\Exceptions;

use ArifAbdd\Azericard\Exceptions\AzericardException;

class SignatureDoesNotMatchException extends AzericardException
{
    public function __construct(
        string $message = "Signature does not match",
        int $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
