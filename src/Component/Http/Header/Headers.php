<?php
/**
 * The Opera Framework
 * Headers.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 5/22/16
 * @version 1.0
 */

namespace Opera\Component\Http\Header;



use ArrayIterator;
use IteratorAggregate;
use Traversable;

class Headers implements IteratorAggregate
{

    /**
     * @var Header[]
     */
    protected $headers = [];

    public function add(Header $header, bool $replace = true)
    {

        if (!$replace && isset($this->headers[$header->getName()])) {
            return;
        }

        $this->headers[$header->getName()] = $header;
    }

    /**
     * @param string $name
     *
     * @return null|Header
     */
    public function get(string $name)
    {
        return isset($this->headers[$name]) ? $this->headers[$name] : null;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     *       <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->headers);
    }
    
    public function __toString() : string
    {
        return implode(Header::NEW_LINE, $this->headers);
    }
    
}