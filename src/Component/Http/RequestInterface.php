<?php
/**
 * The Opera Framework
 * RequestInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   27-8-16
 * @version   1.0
 */

namespace Opera\Component\Http;

use Opera\Component\Http\Header\Header;
use Opera\Component\Http\Header\Headers;

interface RequestInterface
{
    /**
     * @return Headers | Header[]
     */
    public function getHeaders() : Headers;

    /**
     *
     * @return Cookies | Cookie[]
     */
    public function getCookies() : Cookies;

    /**
     * @return ParameterBagInterface
     */
    public function getQuery() : ParameterBagInterface;

    /**
     * @return ParameterBagInterface
     */
    public function getPost() : ParameterBagInterface;

    /**
     * @return string
     */
    public function getMethod() : string;

    /**
     * @param string $method
     */
    public function setMethod(string $method);

    /**
     * @return bool
     */
    public function isHead() : bool;

    /**
     * @return bool
     */
    public function isGet() : bool;

    /**
     * @return bool
     */
    public function isPost() : bool;

    /**
     * @return bool
     */
    public function isUpdate() : bool;

    /**
     * @return bool
     */
    public function isPatch() : bool;

    /**
     * @return bool
     */
    public function isDelete() : bool;

    /**
     * @return bool
     */
    public function isOptions() : bool;

    /**
     * @return string
     */
    public function getUri() : string;

    /**
     * Get the path info
     * which is the uri without the query parameters
     * @return string
     */
    public function getPathInfo();

    /**
     * @return string
     */
    public function getHost() : string;

    /**
     * @param string $uri
     */
    public function setUri(string $uri);

    /**
     * Get the ip address from the client
     *
     * @return string
     */
    public function getIp() : string;

    /**
     * Set the client ip address
     *
     * @param string $ip
     */
    public function setIp(string $ip);
}