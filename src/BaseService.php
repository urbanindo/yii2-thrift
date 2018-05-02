<?php
/**
 * BaseService class file.
 *
 * @since 2018.05.02
 */

namespace UrbanIndo\Yii2\Thrift;

use yii\base\Component;

/**
 * BaseService wraps the service and provides the call event.
 * @author Petra Barus <petra.barus@gmail.com>
 */
abstract class BaseService extends Component implements Service
{

    /**
     * @event ServiceCallEvent an event raised right before executing a controller action.
     * You may set [[ActionEvent::isValid]] to be false to cancel the action execution.
     */
    const EVENT_BEFORE_CALL = 'beforeCall';

    /**
     * @event ServiceCall an event raised right after executing a controller action.
     */
    const EVENT_AFTER_CALL = 'afterCall';

    public function beforeCall($methodName, $params)
    {
        $event = new ServiceCallEvent($methodName, $params);
        $this->trigger(self::EVENT_BEFORE_CALL, $event);
        return $event->isValid;
    }

    public function afterCall($methodName, $params, $result)
    {
        $event = new ServiceCallEvent($methodName, $params);
        $event->result = $result;
        $this->trigger(self::EVENT_AFTER_CALL, $event);
        return $event->result;
    }
}