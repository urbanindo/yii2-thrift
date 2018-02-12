<?php
/**
 * @author Najih Azkalhaq <najih0608@gmail.com>
 * @since 08/02/18 13:15
 */

/**
 * @author Najih Azkalhaq <najih0608@gmail.com>
 * @since 08/02/18 13:15
 */
class ResponseFormatterTest extends PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        // TODO: Implement the test
        $responseFormatter = new \UrbanIndo\Yii2\Thrift\ResponseFormatter();
        $response = new \UrbanIndo\Yii2\Thrift\Response();
        $this->assertEquals('',$responseFormatter->format($response));
    }
}