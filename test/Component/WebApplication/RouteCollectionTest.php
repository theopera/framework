<?php
/**
 * The Opera Framework
 * RouteCollectionTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   9-9-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


use PHPUnit\Framework\TestCase;

class RouteCollectionTest extends TestCase
{

    public function testGetCollectionGood()
    {
        $collection = new RouteCollection('Opera\\Namespace\\');
        $collection->addRoute('/', 'default');

        self::assertInstanceOf(Route::class, $collection->getRoutes()[0]);
    }

}