<?php
/**
 * The Opera Framework
 * AbstractModel.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   6-9-16
 * @version   1.0
 */

namespace Opera\Component\Database;


use PDO;

class AbstractModel
{

    /**
     * @var DatabaseManagerInterface
     */
    private $databaseManager;

    public function __construct(DatabaseManagerInterface $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Get a connection for read commands (e.g. SELECTS)
     *
     * @param int $latency decides which connection will be returned from the connection pool
     *                     a latency 0 usually means that you get a master connection
     *                     a 1 or higher means that you get one of the slaves
     *
     * @return PDO
     */
    protected function getReader(int $latency = 0) : PDO
    {
        return $this->databaseManager->getReadConnection($latency)->getPdo();
    }

    /**
     * Get ta connection for write command (e.g. INSERT, UPDATE and DELETE)
     *
     * @return ConnectionInterface
     */
    protected function getWriter() : PDO
    {
        return $this->databaseManager->getWriteConnection()->getPdo();
    }

    //
    // Helper methods
    //

    protected function insert(string $table, array $data)
    {
        $db = $this->getWriter();

    }

    protected function update(string $table, array $data, int $key)
    {

    }
}