<?php
/**
 * Thrift class file.
 * @since 2015.09.14
 */

namespace UrbanIndo\Yii2\Thrift;

use Thrift\ClassLoader\ThriftClassLoader;

/**
 * Thrift is the component class of
 * @author Petra Barus <petra.barus@gmail.com>
 */
class Thrift extends \yii\base\Component {

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
     * @throws \yii\base\InvalidConfigException if the name definition or service map is empty.
     */
    public function init() {
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
     */
    private function register() {
        $loader = new ThriftClassLoader();
        foreach($this->definitions as $alias => $path) {
            $loader->registerDefinition($alias, $this->path . $path);
        }
        $loader->register();
    }
    
    /**
     * Resolve the service.
     * @param \UrbanIndo\Yii2\Thrift\Request $request
     */
    public function resolveService(Request $request) {
        $pathInfo = $request->getPathInfo();
        $service = \yii\helpers\ArrayHelper::getValue($this->serviceMap, $pathInfo);
        if ($service == null) {
            $service = $pathInfo;
        }
        if (is_string($service)) {
            $class = $this->serviceNamespace . '\\' . \yii\helpers\Inflector::id2camel($service) . 'Service';
            $handler = new $class;
        } else if (is_array($service)){
            $handler = \Yii::createObject($service);
        }
        /* @var $handler Service */
        if (!$handler instanceof Service) {
            throw new \yii\base\InvalidCallException('Service not found');
        }
        $processorClassName = $handler->getProcessorClass();
        $processor = new $processorClassName($handler);
        return $processor;
    }
}
