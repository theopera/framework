<?php
/**
 * The Opera Framework
 * ConnectionInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   6-9-16
 * @version   1.0
 */
namespace Opera\Component\Database;

use PDO;

interface ConnectionInterface
{
    /**
     * @return boolean
     */
    public function isReadable() : bool;

    /**
     * @return boolean
     */
    public function isWritable() : bool;

    /**
     * @return PDO
     */
    public function getPdo() : PDO;
}