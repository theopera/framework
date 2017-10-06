<?php
/**
 * The Opera Framework
 * JsonResponse.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license MIT
 * @created 31-5-16
 * @version 1.0
 */

namespace Opera\Component\Http;


use Opera\Component\Http\Header\Header;
use Opera\Component\Http\Header\Headers;

class JsonResponse extends Response
{

    /**
     * JsonResponse constructor.
     *
     * @param mixed $data
     */
    public function __construct($data, $jsonOptions = 0, int $statusCode = Response::STATUS_OK, Headers $headers = null)
    {
        $json = json_encode($data, $jsonOptions);
        parent::__construct($json, $statusCode, $headers);

        $this->headers->add(new Header('Content-Type', Mime::APPLICATION_JSON), true);
    }
}