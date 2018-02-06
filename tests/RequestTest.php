<?php
/**
 * @author Najih Azkalhaq <najih0608@gmail.com>
 * @since 08/02/18 13:14
 */

/**
 * @author Najih Azkalhaq <najih0608@gmail.com>
 * @since 08/02/18 13:14
 */
class RequestTest extends PHPUnit_Framework_TestCase
{
    public function testResolveService()
    {
        // TODO: Implement the test
        $request = new \UrbanIndo\Yii2\Thrift\Request();
        $this->assertInstanceOf(
            \UrbanIndo\Yii2\Thrift\Request::class,
            $request,
            "Must be Instance of object"
        );
    }
}