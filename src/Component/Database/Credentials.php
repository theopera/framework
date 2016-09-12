<?php
/**
 * The Opera Framework
 * Credentials.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license MIT
 * @created 30-5-16
 * @version 1.0
 */

namespace Opera\Component\Database;


class Credentials
{
    /**
     * @var string
     */
    private $driver = '';

    /**
     * @var string
     */
    private $hostname = '';

    /**
     * @var string
     */
    private $username = '';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $database = '';
    
    /**
     * @var string
     */
    private $encoding;

    /**
     * Credentials constructor.
     *
     * @param string $driver
     * @param string $hostname
     * @param string $database
     * @param string|null $username
     * @param string|null $password
     * @param string $encoding
     */
    public function __construct(
        string $driver,
        string $hostname,
        string $database,
        string $username = null,
        string $password = null,
        string $encoding = 'UTF-8'
    ){
        $this->driver = $driver;
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->encoding = $encoding;
    }

    public function getDSN() : string
    {
        return sprintf('%s:host=%s;dbname=%s;',
            $this->driver,
            $this->hostname,
            $this->database,
            $this->encoding
        );
    }

    /**
     * @return string
     */
    public function getDriver() : string
    {
        return $this->driver;
    }

    /**
     * @return string
     */
    public function getHostname() : string
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }
    

    /**
     * @return string
     */
    public function getDatabase() : string
    {
        return $this->database;
    }

    /**
     * @return string
     */
    public function getEncoding() : string
    {
        return $this->encoding;
    }
    
}