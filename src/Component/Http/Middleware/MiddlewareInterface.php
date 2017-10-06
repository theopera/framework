<?php
/**
 * The Opera Framework
 * MiddlewareInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   2-9-16
 * @version   1.0
 */

namespace Opera\Component\Http\Middleware;


use Opera\Component\Http\RequestInterface;
use Opera\Component\Http\ResponseInterface;

interface MiddlewareInterface
{
    public function handle(MiddlewareCollectionInterface $collection, RequestInterface $request) : ResponseInterface;
}