<?php
/**
 * The Opera Framework
 * ResponseInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   27-8-16
 * @version   1.0
 */

namespace Opera\Component\Http;

use Opera\Component\Http\Header\Headers;

interface ResponseInterface
{
    /**
     * Returns the status code
     * 0 will be provided if there is no status code
     *
     * @return int
     */
    public function getStatusCode() : int;

    /**
     * Get the complete status line
     *
     * @return string
     */
    public function getStatusLine() : string;

    /**
     * @return Headers
     */
    public function getHeaders() : Headers;

    /**
     * Returns the content type.
     * If no Content-Type header was given plain/text will be returned.
     *
     * @return string
     */
    public function getContentType() : string;

    /**
     * @return string
     */
    public function getBody() : string;

    /**
     * @param string $body
     */
    public function setBody(string $body);

    /**
     * Sends the response to the web server
     *
     * @return void
     */
    public function send();
}