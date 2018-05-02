<?php
/**
 * Handler class file.
 *
 * @since 2018.05.02
 */

namespace UrbanIndo\Yii2\Thrift;

use yii\base\Component;
use yii\base\InvalidCallException;

/**
 * Handler wraps the service.
 * @author Petra Barus <petra.barus@gmail.com>
 */
class Handler extends Component implements Service
{
    /**
     * @var Service
     */
    public $service;

    /**
     * Initializes.
     * @return void
     * @throws InvalidCallException When service not found.
     */
    public function init()
    {
        parent::init();
        if (!$this->service instanceof Service) {
            throw new InvalidCallException('Service not found');
        }
    }

    /**
     * @param mixed   $methodName The method called for the service.
     * @param mixed[] $params     The params.
     * @return mixed|null
     */
    public function __call($methodName, $params)
    {
        if (!$this->service instanceof BaseService) {
            return $this->execute($methodName, $params);
        }

        $result = null;
        if ($this->service->beforeCall($methodName, $params)) {
            $result = $this->execute($methodName, $params);
            $result = $this->service->afterCall($methodName, $params, $result);
        }
        return $result;
    }

    /**
     * @param mixed   $methodName The method called for the service.
     * @param mixed[] $params     The params.
     * @return mixed|null
     */
    private function execute($methodName, $params)
    {
        return call_user_func_array([$this->service, $methodName], $params);
    }

    /**
     * @return string
     */
    public function getProcessorClass()
    {
        return $this->service->getProcessorClass();
    }
}
