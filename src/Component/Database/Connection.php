<?php
/**
 * The Opera Framework
 * Database.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 30-5-16
 * @version 1.0
 */

namespace Opera\Component\Database;


use PDO;

class Connection implements ConnectionInterface
{

    private $readable = true;

    private $writable = true;

    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Connection constructor.
     *
     * @param Credentials $credentials
     * @param bool $readable
     * @param bool $writable
     */
    public function __construct(Credentials $credentials, bool $readable = true, bool $writable = true)
    {
        $this->pdo = $this->connect($credentials);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        $this->credentials = $credentials;
        $this->readable = $readable;
        $this->writable = $writable;
    }

    /**
     * Makes the actual connection to the database
     * 
     * @param Credentials $credentials
     * @return PDO
     */
    private function connect(Credentials $credentials) : PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO($credentials->getDSN(), $credentials->getUsername(), $credentials->getPassword());
        }

        return $this->pdo;
    }

    /**
     * @return boolean
     */
    public function isReadable() : bool
    {
        return $this->readable;
    }

    /**
     * @return boolean
     */
    public function isWritable() : bool
    {
        return $this->writable;
    }

    /**
     * @return PDO
     */
    public function getPdo() : PDO
    {
        return $this->pdo;
    }
}