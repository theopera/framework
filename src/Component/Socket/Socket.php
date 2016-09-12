<?php
/**
 * The Opera Framework
 * Socket.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license MIT
 * @created 10-6-16
 * @version 1.0
 */

namespace Opera\Component\Socket;


abstract class Socket
{
    /**
     * @var string
     */
    protected $hostname;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var resource
     */
    protected $socket;

    public function __construct(string $hostname, int $port)
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $this->hostname = $hostname;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getHostname() : string
    {
        return $this->hostname;
    }

    /**
     * @return int
     */
    public function getPort() : int
    {
        return $this->port;
    }
}