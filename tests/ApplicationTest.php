<?php
/**
 * ApplicationTest class file.
 *
 * @since 2015.09.14
 * @author Najih Azkalhaq <najih@urbanindo.com>
 */

class ApplicationTest extends PHPUnit_Framework_TestCase
{
    public function testCoreComponents()
    {
        $config = [
            'id' => 'Yii2 Thrift Test',
            'basePath' => dirname(__FILE__),
            'components' => [
                'thrift' => [
                    'class' => '\UrbanIndo\Yii2\Thrift\Thrift'
                ]
            ]
        ];
        $yiiApp = new \yii\web\Application($config);
        $expected = array_merge($yiiApp->coreComponents(), [
            'request' => ['class' => 'UrbanIndo\Yii2\Thrift\Request'],
            'response' => ['class' => 'UrbanIndo\Yii2\Thrift\Response'],
            'session' => ['class' => 'yii\web\Session'],
            'user' => ['class' => 'yii\web\User'],
            'errorHandler' => ['class' => 'yii\web\ErrorHandler'],
            'thrift' => ['class' => 'UrbanIndo\Yii2\Thrift\Thrift']
        ]);
        $app = new \UrbanIndo\Yii2\Thrift\Application($config);
        $result = $app->coreComponents();

        $this->assertEquals($result, $expected);
    }
}