<?php
/**
 * ServiceCallEvent class file.
 *
 * @since 2018.05.02
 */

namespace UrbanIndo\Yii2\Thrift;

use yii\base\Event;

/**
 * ServiceCallEvent event to handle the call event.
 * @author Petra Barus <petra.barus@gmail.com>
 */
class ServiceCallEvent extends Event
{
    /**
     * @var string The service method that being called.
     */
    public $call;

    /**
     * @var mixed[] The params for the service call.
     */
    public $params;

    /**
     * @var mixed
     */
    public $result;

    /**
     * @var bool whether to continue running the action. Event handlers of
     * [[BaseService::EVENT_BEFORE_CALL]] may set this property to decide whether
     * to continue running the current action.
     */
    public $isValid = true;

    public function __construct($call, $params, array $config = [])
    {
        $this->call = $call;
        $this->params = $params;
        parent::__construct($config);
    }
}