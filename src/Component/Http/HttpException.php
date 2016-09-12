<?php
/**
 * The Opera Framework
 * HttpException.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license MIT
 * @created 5/22/16
 * @version 1.0
 */

namespace Opera\Component\Http;



use Exception;

class HttpException extends Exception
{
    private $statusCode = 404;

    public function __construct(int $statusCode, $message = null, Exception $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode() : int
    {
        return $this->statusCode;
    }
    
    public static function badRequest(string $message = 'The provided request is not valid') : HttpException
    {
        return new HttpException(Response::STATUS_BAD_REQUEST, $message);
    }

    public static function notFound(string $message = 'The provided request could not be found') : HttpException
    {
        return new HttpException(Response::STATUS_NOT_FOUND, $message);
    }

    public static function unauthorized(string $message = 'You are not authorized to view this page')
    {
        return new HttpException(Response::STATUS_UNAUTHORIZED, $message);
    }

    public static function forbidded(string $message = 'Permission dendied')
    {
        return new HttpException(Response::STATUS_FORBIDDEN, $message);
    }
}