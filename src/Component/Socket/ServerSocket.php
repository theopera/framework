<?php
/**
 * The Opera Framework
 * ServerSocket.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 10-6-16
 * @version 1.0
 */

namespace Opera\Component\Socket;


class ServerSocket extends Socket
{
    public function __construct(string $hostname, int $port)
    {
        parent::__construct($hostname, $port);
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($this->socket, $hostname, $port);
    }

    public function listen(int $backlog = 5){
        socket_listen($this->socket, $backlog);
    }

    public function accept() : Communicator{
        $socket = socket_accept($this->socket);
        return new Communicator($socket);
    }
}