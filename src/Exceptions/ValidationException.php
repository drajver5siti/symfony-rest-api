<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationList;
use Throwable;

class ValidationException extends HttpException
{
    /**
     * @param int $statusCode
     * @param string $message
     */
    public function __construct($statusCode, ConstraintViolationList $errors)
    {
        $msg = $errors->get(0)->getMessage();
        $msg = str_replace(["\\", "\""], "", $msg);
        parent::__construct($statusCode, $msg);
    }
}
