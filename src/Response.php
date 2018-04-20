<?php
/**
 * Response class file.
 * @since 2015.09.14
 */

namespace UrbanIndo\Yii2\Thrift;

use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TPhpStream;
use Thrift\Protocol\TBinaryProtocol;

/**
 * Response
 * @author Petra Barus <petra.barus@gmail.com>
 */
class Response extends \yii\web\Response
{
    
    const FORMAT_THRIFT = 'thrift';

    /**
     * Define thrift format.
     * @var string
     */
    public $format = self::FORMAT_THRIFT;

    /**
     * @var integer
     */
    public $bufferSize = 1024;
    
    /**
     * Define thrift transport.
     * @var \Thrift\Transport\TTransport
     */
    private $_transport;
    
    /**
     * Define the thrift protocol.
     * @var \Thrift\Protocol\TProtocol
     */
    private $_protocol;
    
    /**
     * @var object
     */
    private $_processor;
    
    /**
     * Initialize the response.
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->formatters = [
            self::FORMAT_THRIFT => 'UrbanIndo\Yii2\Thrift\ResponseFormatter',
        ];
        $phpTransport = new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W);
        $this->_transport = new TBufferedTransport($phpTransport, $this->bufferSize, $this->bufferSize);
        $this->_protocol = new TBinaryProtocol($this->_transport, true, true);
    }
    
    /**
     * @param object $processor Processor.
     * @return void
     */
    public function setProcessor($processor)
    {
        $this->_processor = $processor;
    }

    /**
     * @return void
     */
    protected function sendContent()
    {
        $this->content = $this->getThriftOutput();
        return parent::sendContent();
    }

    /**
     * @return string
     */
    private function getThriftOutput()
    {
        ob_start();
        $this->_transport->open();
        $this->_processor->process($this->_protocol, $this->_protocol);
        $this->_transport->close();
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
