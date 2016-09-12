<?php
/**
 * The Opera Framework
 * Cookie.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Http;


class Cookie
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var int
     */
    private $expire;

    public function __construct(string $name, string $value = null, int $expire = 0)
    {

        $this->name = $name;
        $this->value = $value;
        $this->expire = $expire;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getExpire() : int
    {
        return $this->expire;
    }

    public function __toString() : string
    {
        return urlencode($this->name) . '=' . urlencode($this->value) . '; expires=' . $this->expire;
    }


    public static function parseFromString(string $input)
    {

    }
}