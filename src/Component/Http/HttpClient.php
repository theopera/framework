<?php
/**
 * The Opera Framework
 * Client.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license MIT
 * @created 10-6-16
 * @version 1.0
 */

namespace Opera\Component\Http;


use Opera\Component\Http\Header\Header;
use Opera\Component\Http\Header\Headers;
use Opera\Component\Socket\ClientSocket;
use SebastianBergmann\CodeCoverage\Report\PHP;


class HttpClient
{

    public function __construct()
    {

    }


    /**
     * Executes a http request
     * on success a Response object will be returned
     * 
     * @param Request $request
     * @return Response
     */
    public function execute(Request $request) : Response
    {
        $host = $request->getHost();
        $socket = new ClientSocket($host, 80);
        $socket->connect();
        $communicator = $socket->getCommunicator();
        $communicator->write($request);
        $communicator->writeLine('');$communicator->writeLine('');
        
        $headers = new Headers();
        $body = ''; 
        
        $headerLine = true;

        $statusLine = $communicator->read(1024, PHP_NORMAL_READ);
        while($line = $communicator->read(5000, PHP_NORMAL_READ)){

            if ($headerLine && $line === PHP_EOL) {
                continue;
            }

            if ($headerLine && ($line === "\r" || $line === PHP_EOL)) {
                $headerLine = false;
                continue;
            }

            if ($headerLine) {
                $headers->add(Header::createFromString($line));
            }else{
                $body .= $line;
            }

        }

        return new Response($body, 200, $headers);
    }
}