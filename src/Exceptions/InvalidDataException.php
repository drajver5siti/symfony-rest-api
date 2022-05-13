<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidDataException extends HttpException
{
    /**
     * @param int $statusCode
     * @param string $message
     */
    public function __construct($statusCode, $message)
    {
        parent::__construct($statusCode, $message);
    }
}
