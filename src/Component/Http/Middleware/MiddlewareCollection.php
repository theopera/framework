<?php
/**
 * The Opera Framework
 * MiddlewareCollection.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   3-9-16
 * @version   1.0
 */

namespace Opera\Component\Http\Middleware;


use Opera\Component\Http\RequestInterface;
use Opera\Component\Http\ResponseInterface;

class MiddlewareCollection implements MiddlewareCollectionInterface
{

    /**
     * @var MiddlewareInterface[]
     */
    protected $collection;

    /**
     * The index of the middleware that is currently being executed
     * @var int
     */
    protected $current = 0;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * MiddlewareCollection constructor.
     *
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function add(MiddlewareInterface $middleware) : MiddlewareCollectionInterface
    {
        $this->collection[] = $middleware;

        return $this;
    }

    public function hasNext() : bool
    {
        return count($this->collection) - 1 > $this->current;
    }

    public function next() : ResponseInterface
    {
        return $this->collection[$this->current++]->handle($this, $this->request);
    }
}