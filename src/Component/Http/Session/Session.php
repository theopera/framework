<?php
/**
 * The Opera Framework
 * Session.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Http\Session;


use Opera\Component\Http\ParameterBag;

class Session extends ParameterBag implements SessionInterface
{

    /**
     * @var string
     */
    private $id;

    /**
     * Session constructor.
     *
     * @param string $id
     * @param string[] $data
     */
    public function __construct(string $id, array $data = [])
    {
        parent::__construct($data);

        $this->id = $id;
    }


    public function getId() : string
    {
        return $this->id;
    }

    public function remove(string $key)
    {
        unset($this->parameters[$key]);
    }
}