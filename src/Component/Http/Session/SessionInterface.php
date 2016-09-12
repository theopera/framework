<?php
/**
 * The Opera Framework
 * SessionInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Http\Session;


use Opera\Component\Http\ParameterBag;
use Opera\Component\Http\ParameterBagInterface;

interface SessionInterface extends ParameterBagInterface
{

    public function getId() : string;

}