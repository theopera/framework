<?php
/**
 * The Opera Framework
 * Communicator.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license MIT
 * @created 10-6-16
 * @version 1.0
 */

namespace Opera\Component\Socket;


use Exception;

class Communicator
{
    /**
     * @var resource
     */
    private $socket;

    /**
     * @param $socket
     *
     * @throws Exception
     */
    public function __construct($socket)
    {

        if(!is_resource($socket)){
            throw new Exception('Given socket is not a resource');
        }

        $this->socket = $socket;
    }

    public function write(string $message)
    {
        socket_write($this->socket, $message, strlen($message));
    }

    public function writeLine(string $message)
    {
        $this->write($message . PHP_EOL);
    }

    public function read(int $buffer, int $type = PHP_BINARY_READ) : string
    {
        $read = @socket_read($this->socket, $buffer, $type);
        return $read;
    }

    public function close()
    {
        socket_close($this->socket);
    }
}