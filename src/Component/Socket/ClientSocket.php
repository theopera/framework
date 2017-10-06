<?php
/**
 * The Opera Framework
 * ClientSocket.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 10-6-16
 * @version 1.0
 */

namespace Opera\Component\Socket;


class ClientSocket extends Socket
{
    public function __construct(string $hostname, int $port){
        parent::__construct($hostname, $port);
    }

    public function connect(){
        socket_connect($this->socket, $this->hostname, $this->port);
    }

    public function getCommunicator() : Communicator{
        return new Communicator($this->socket);
    }

}