<?php
require dirname(__FILE__) . '/../vendor/autoload.php';
require dirname(__FILE__) . '/../vendor/yiisoft/yii2/Yii.php';
require dirname(__FILE__) . '/TestCase.php';

$config = [
    'id' => 'Yii2 Thrift Test',
    'basePath' => dirname(__FILE__),
    'components' => [
        'thrift' => [
            'class' => '\UrbanIndo\Yii2\Thrift\Thrift'
        ]
    ]
];
$application = new yii\console\Application($config);