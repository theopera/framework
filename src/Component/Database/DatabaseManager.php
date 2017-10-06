<?php
/**
 * The Opera Framework
 * DatabaseManager.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 30-5-16
 * @version 1.0
 */

namespace Opera\Component\Database;


class DatabaseManager implements DatabaseManagerInterface
{
    
    const LATENCY_NONE = 0;
    
    const LATENCY_MINIMAL = 1;
    

    /**
     * @var Connection
     */
    private $readConnection;

    /**
     * @var Connection
     */
    private $writeConnection;

    /**
     * Add a connection to the pool
     *
     * @param ConnectionInterface $connection
     */
    public function addConnection(ConnectionInterface $connection)
    {
        // TODO: This should be a pool of connections


        if ($connection->isReadable()) {
            $this->readConnection = $connection;
        }

        if ($connection->isWritable()) {
            $this->writeConnection = $connection;
        }
    }

    /**
     * @param int $latency
     * 
     * @return ConnectionInterface
     */
    public function getReadConnection(int $latency = 0) : ConnectionInterface
    {
        return $this->readConnection;
    }

    /**
     * @return ConnectionInterface
     */
    public function getWriteConnection() : ConnectionInterface
    {
        return $this->writeConnection;
    }
}