<?php
/**
 * The Opera Framework
 * MessageTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   9-9-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{

    public function testSimpleMessageGood()
    {
        $message = new Message(Message::TYPE_DANGER, 'Watch out, this is dangerous', 'Hold your position');

        self::assertEquals('danger', $message->getType());
        self::assertEquals('Hold your position', $message->getTitle());
        self::assertEquals('Watch out, this is dangerous', $message->getMessage());

    }

}