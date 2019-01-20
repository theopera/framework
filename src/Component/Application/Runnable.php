<?php
/**
 * The Opera Framework
 * Runnable.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   25-11-18
 * @version   1.0
 */

namespace Opera\Component\Application;


use Opera\Component\Application\Io\InInterface;
use Opera\Component\Application\Io\OutInterface;

interface Runnable
{

    /**
     * Executes the command
     *
     * @param ArgumentBag $argumentBag
     * @param InInterface $in
     * @param OutInterface $out
     * @param OutInterface|null $err
     * @return int
     */
    public function run(ArgumentBag $argumentBag, InInterface $in, OutInterface $out, OutInterface $err = null): int;

}