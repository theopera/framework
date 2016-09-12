<?php
/**
 * The Opera Framework
 * AuthenticationException.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   6-9-16
 * @version   1.0
 */

namespace Opera\Component\Authentication;


use Exception;

class AuthenticationException extends Exception
{

    public static function notConfigured() : AuthenticationException
    {
        return new AuthenticationException('Authentication component is not configured');
    }
}