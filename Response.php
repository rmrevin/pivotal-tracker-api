<?php
/**
 * Response.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal;

use rmrevin\pivotal\exceptions\InvalidParamException;
use rmrevin\pivotal\interfaces\RequestInterface;
use rmrevin\pivotal\interfaces\ResponseInterface;
use rmrevin\pivotal\traits\ConfigurableTrait;

/**
 * Class Response
 * @package rmrevin\pivotal
 */
class Response implements ResponseInterface
{

    use ConfigurableTrait;

    /** @var array */
    public $_data;

    /** @var API */
    public $api;

    /** @var RequestInterface */
    public $request;

    /** @var array */
    public $headers = [];

    /**
     * Response constructor.
     * @param array $config
     * @throws InvalidParamException
     */
    public function __construct($config = [])
    {
        $this->configure($this, $config);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}