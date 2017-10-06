<?php
/**
 * The Opera Framework
 * Header.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 5/22/16
 * @version 1.0
 */

namespace Opera\Component\Http\Header;



class Header implements HeaderInterface
{

    const NEW_LINE = "\r\n";

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string[]
     */
    private $properties;

    /**
     * @param string   $name
     * @param string   $value
     * @param string[] $properties
     */
    public function __construct(string $name, string $value, array $properties = [])
    {
        $this->name = $name;
        $this->value = $value;
        $this->properties = $properties;
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
        $properties = '';
        foreach ($this->properties as $name => $value) {
            $properties .= sprintf('; %s="%s" ', $name, $value);
        };

        return $this->value . $properties;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * Returns true if the given string can be found in the header value
     *
     * @param string $value
     *
     * @return bool
     */
    public function contains(string $value) : bool
    {
        return strpos($this->value, $value) !== false;
    }

    public function __toString() : string
    {
        return sprintf('%s: %s', $this->name, $this->getValue());
    }

    /**
     * @param string $string
     *
     * @return Header
     */
    public static function createFromString(string $string)
    {
        $string = trim($string);
        $parts = explode(': ', $string, 2);

        return new Header($parts[0], $parts[1]);
    }
}
