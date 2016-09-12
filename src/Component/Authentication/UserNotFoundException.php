<?php
/**
 * The Opera Framework
 * UserNotFoundException.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Authentication;


use Exception;

class UserNotFoundException extends Exception
{

    public static function notFound(string $username)
    {
        return new UserNotFoundException(sprintf('User "%s" could not be found', $username));
    }
}