<?php
/**
 * The Opera Framework
 * DatabaseManagerInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   6-9-16
 * @version   1.0
 */
namespace Opera\Component\Database;

interface DatabaseManagerInterface
{
    /**
     * Add a connection to the pool
     *
     * @param ConnectionInterface $connection
     */
    public function addConnection(ConnectionInterface $connection);

    /**
     * @param int $latency
     *
     * @return ConnectionInterface
     */
    public function getReadConnection(int $latency = 0) : ConnectionInterface;

    /**
     * @return ConnectionInterface
     */
    public function getWriteConnection() : ConnectionInterface;
}