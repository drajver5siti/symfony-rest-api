<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{
    /**
     * @param int $statusCode
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct(401, $message);
    }
}
