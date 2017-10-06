<?php
/**
 * The Opera Framework
 * MiddlewareCollectionInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   3-9-16
 * @version   1.0
 */

namespace Opera\Component\Http\Middleware;


use Opera\Component\Http\ResponseInterface;

interface MiddlewareCollectionInterface
{
    public function add(MiddlewareInterface $middleware) : MiddlewareCollectionInterface;

    public function hasNext() : bool;

    public function next() : ResponseInterface;
}