<?php
/**
 * The Opera Framework
 * MimeTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   8-9-16
 * @version   1.0
 */

namespace Opera\Component\Http;


class MimeTest extends \PHPUnit_Framework_TestCase
{

    public function testFromExtensionGood()
    {
        self::assertEquals('text/plain', Mime::fromExtension('txt'));
        self::assertEquals('text/html', Mime::fromExtension('html'));
        self::assertEquals('application/pdf', Mime::fromExtension('pdf'));
    }
}
