<?php
/**
 * The Opera Framework
 * Cookies.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   27-8-16
 * @version   1.0
 */

namespace Opera\Component\Http;


use ArrayIterator;
use IteratorAggregate;
use Traversable;

class Cookies implements IteratorAggregate
{

    protected $cookies = [];


    public function add(Cookie $cookie)
    {
        $this->cookies[] = $cookie;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->cookies);
    }
}