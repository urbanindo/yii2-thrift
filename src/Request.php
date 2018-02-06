<?php
/**
 * Request class file.
 * @since 2015.09.14
 */

namespace UrbanIndo\Yii2\Thrift;

/**
 * Request handle thrift request.
 * @author Petra Barus <petra.barus@gmail.com>
 */
class Request extends \yii\web\Request {
    
    /**
     * Resolve the service route to the service handler.
     * 
     * @return object the processor object.
     */
    public function resolveService() {
        return \Yii::$app->get('thrift')->resolveService($this);
    }
}
