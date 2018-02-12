<?php
/**
 * Service class file.
 * @since 2015.09.14
 */

namespace UrbanIndo\Yii2\Thrift;

/**
 * Service provide method for the processor class name.
 */
interface Service
{
    
    /**
     * @return string the class name of the processor class.
     */
    public function getProcessorClass();
}
