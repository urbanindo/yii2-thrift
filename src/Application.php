<?php

namespace UrbanIndo\Yii2\Thrift;

/**
 * Application is the base class of Thrift application.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 */
class Application extends \yii\web\Application {
    
    /**
     * @param Request $request
     * @return Response
     */
    public function handleRequest($request) {
        $processor = $request->resolveService();
        $response = $this->getResponse();
        $response->setProcessor($processor);
        return $response;
    }
    
    /**
     * @inheritdoc
     */
    public function coreComponents()
    {
        return array_merge(parent::coreComponents(), [
            'request' => ['class' => 'UrbanIndo\Yii2\Thrift\Request'],
            'response' => ['class' => 'UrbanIndo\Yii2\Thrift\Response'],
            'session' => ['class' => 'yii\web\Session'],
            'user' => ['class' => 'yii\web\User'],
            'errorHandler' => ['class' => 'yii\web\ErrorHandler'],
            'thrift' => ['class' => 'UrbanIndo\Yii2\Thrift\Thrift']
        ]);
    }   
}
