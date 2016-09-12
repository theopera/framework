<?php
/**
 * The Opera Framework
 * DatabaseException.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   6-9-16
 * @version   1.0
 */

namespace Opera\Component\Database;


use Exception;

class DatabaseException extends Exception
{
    public static function notConfigured() : DatabaseException
    {
        return new DatabaseException('No database manager configured');
    }

}