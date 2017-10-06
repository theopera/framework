<?php
/**
 * The Opera Framework
 * SqliteConnection.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   6-9-16
 * @version   1.0
 */

namespace Opera\Component\Database;


use PDO;

class SqliteConnection implements ConnectionInterface
{

    /**
     * @var string
     */
    private $file;

    /**
     * @var int
     */
    private $version;

    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(string $file, int $version)
    {
        $this->file = $file;
        $this->version = $version;
    }

    public function isReadable() : bool
    {
        return true;
    }

    public function isWritable() : bool
    {
        return true;
    }

    public function getPdo() : PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO($this->getDSN());
        }

        return $this->pdo;
    }

    private function getDSN() : string
    {
        $version = $this->version === 3 ? null : $this->version;
        return sprintf('sqlite%s:%s', $version, $this->file);
    }
}