<?php
/**
 * The Opera Framework
 * HeaderInterface.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 5/22/16
 * @version 1.0
 */

namespace Opera\Component\Http\Header;



interface HeaderInterface
{

    public function getName() : string;

    public function getValue() : string;
}