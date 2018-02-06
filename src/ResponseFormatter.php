<?php
/**
 * ResponseFormatter class file.
 * @since 2015.09.14
 */

namespace UrbanIndo\Yii2\Thrift;

/**
 * ResponseFormatter set the response header as thrift application.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 */
class ResponseFormatter extends \yii\base\Component implements \yii\web\ResponseFormatterInterface {

    /**
     * @var string the Content-Type header for the response
     */
    public $contentType = 'application/x-thrift';

    /**
     * Format the content type of the response.
     * @param Response $response
     */
    public function format($response) {
        $response->getHeaders()->set('Content-Type', $this->contentType);
    }

}
