<?php
/**
 * The Opera Framework
 * Application.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   8-7-16
 * @version   1.0
 */

namespace Opera\Component\Application;


use Opera\Component\Application\Io\In;
use Opera\Component\Application\Io\InInterface;
use Opera\Component\Application\Io\Out;
use Opera\Component\Application\Io\OutInterface;

abstract class Application
{
    /**
     * @var Context
     */
    private $context;

    /**
     * Application constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @param ArgumentBag $argumentBag
     * @param InInterface $in
     * @param OutInterface $out
     * @param OutInterface|null $err
     * @return int Exit code
     */
    public abstract function run(
        ArgumentBag $argumentBag,
        InInterface $in,
        OutInterface $out,
        OutInterface $err = null
    ): int;

    /**
     * @param string[] $args
     * @param InInterface|null $in
     * @param OutInterface|null $out
     * @param OutInterface|null $err
     * @return int
     */
    public function start(
        array $args = [],
        InInterface $in = null,
        OutInterface $out = null,
        OutInterface $err = null): int
    {
        $in = $in ?? In::open('php://stdin');
        $out = $out ?? Out::open('php://stdout');
        $err = $err ?? Out::open('php://stderr');

        return $this->run(new ArgumentBag($args), $in, $out, $err);
    }

    /**
     * @return Context
     */
    protected function getContext(): Context
    {
        return $this->context;
    }
}