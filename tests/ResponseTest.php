<?php
/**
 * @author Najih Azkalhaq <najih0608@gmail.com>
 * @since 08/02/18 13:15
 */

/**
 * @author Najih Azkalhaq <najih0608@gmail.com>
 * @since 08/02/18 13:15
 */
class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        // TODO: Implement the test
        $response = new \UrbanIndo\Yii2\Thrift\Response();
        $this->assertNotNull($response->format);
        $this->assertEquals('thrift', $response->format);
    }

    public function testSetProcessor()
    {
        // TODO: Implement the test
    }

    public function testSend()
    {
        // TODO: Implement the test
    }
}