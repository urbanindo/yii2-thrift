<?php
/**
 * Thrift class file.
 * @since 2015.09.14
 */

namespace UrbanIndo\Yii2\Thrift;

use PHPUnit\Framework\Exception;
use Thrift\ClassLoader\ThriftClassLoader;
use yii\base\InvalidCallException;

/**
 * Thrift is the component class of
 * @author Petra Barus <petra.barus@gmail.com>
 */
class Thrift extends \yii\base\Component
{

    /**
     * The path of the thrift generated files.
     * @var string
     */
    public $path;
    
    /**
     * The list of namespace definitions and the related relative path from the thrift
     * generated file directory.
     *
     * The format is like this
     * ```
     * [
     *    'namespace' => '' //if the path is in the root of the directory.
     * ]
     * ```
     * @var array
     */
    public $definitions;
    
    /**
     * The service map between URL path and service handler.
     *
     * The format is like this
     *
     * ```
     * [
     *    'route' => 'hello'
     * ]
     * ```
     *
     * The hello will be resolve to HelloService located in the `$serviceNamespace`.
     *
     * or it can also be
     *
     * ```
     * [
     *    'route' => [
     *       'class' => 'app\services\HelloService',
     *    ]
     * ]
     * ```
     *
     * @var array
     */
    public $serviceMap = [];
    
    /**
     * The namespace of the service
     * @var string
     */
    public $serviceNamespace;
    
    /**
     * Initialize the component.
     * @throws \yii\base\InvalidConfigException If the name definition or service map is empty.
     * @return mixed
     */
    public function init()
    {
        parent::init();
        if (empty($this->path)) {
            $this->path = \Yii::$app->getBasePath() . DIRECTORY_SEPARATOR . 'gen-php';
        }
        if (empty($this->definitions)) {
            throw new \yii\base\InvalidConfigException('Namespace definitions can not be empty');
        }
        if (empty($this->serviceMap)) {
            throw new \yii\base\InvalidConfigException('Service maps can not be empty');
        }
        $this->register();
    }
    
    /**
     * Register alias load.
     * @return void
     */
    private function register()
    {
        $loader = new ThriftClassLoader();
        foreach ($this->definitions as $alias => $path) {
            $loader->registerDefinition($alias, $this->path . $path);
        }
        $loader->register();
    }
    
    /**
     * Resolve the service.
     * @param \UrbanIndo\Yii2\Thrift\Request $request Request.
     * @return mixed
     * @throws InvalidCallException Exception.
     */
    public function resolveService(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $serviceName = \yii\helpers\ArrayHelper::getValue($this->serviceMap, $pathInfo);
        if ($serviceName == null) {
            $serviceName = $pathInfo;
        }
        if (is_string($serviceName)) {
            $class = $this->serviceNamespace . '\\' . \yii\helpers\Inflector::id2camel($serviceName) . 'Service';
            $service = new $class();
        } else if (is_array($serviceName)) {
            $service = \Yii::createObject($serviceName);
        } else {
            throw new InvalidCallException('Cannot find service');
        }
        $handler = new Handler(['service' => $service]);
        $processorClassName = $handler->getProcessorClass();
        $processor = new $processorClassName($handler);
        return $processor;
    }
}
