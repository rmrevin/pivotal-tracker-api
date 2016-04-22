<?php
/**
 * Request.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal;

use rmrevin\pivotal\interfaces\ResponseInterface;
use rmrevin\pivotal\traits\ConfigurableTrait;

/**
 * Class Request
 * @package rmrevin\pivotal
 */
class Request implements interfaces\RequestInterface
{

    use ConfigurableTrait;

    /** @var API */
    public $api;

    /** @var string */
    public $method = 'GET';

    /** @var string */
    public $command;

    /** @var array */
    public $query = [];

    /** @var string */
    public $responseClass = 'rmrevin\pivotal\Response';

    /** @var string */
    public $errorResponseClass = 'rmrevin\pivotal\ErrorResponse';

    /**
     * Request constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->configure($this, $config);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return string
     */
    public function pushQuery($key, $value)
    {
        $this->query[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function buildUrl()
    {
        return sprintf(
            '%s/%s?%s',
            $this->api->client->getApiUrl(),
            $this->command,
            http_build_query($this->query)
        );
    }

    /**
     * @return static
     */
    public function createClone()
    {
        return new static([
            'api' => $this->api,
            'method' => $this->method,
            'command' => $this->command,
            'query' => $this->query,
            'responseClass' => $this->responseClass,
            'errorResponseClass' => $this->errorResponseClass,
        ]);
    }

    /**
     * @return ResponseInterface
     */
    public function send()
    {
        return $this->api->transport
            ->capture($this)
            ->send($this->method, $this->buildUrl());
    }

    /**
     * @param array $config
     * @return mixed
     */
    public function createResponse($config = [])
    {
        return new $this->responseClass($config);
    }

    /**
     * @param array $config
     * @return mixed
     */
    public function createErrorResponse($config = [])
    {
        return new $this->errorResponseClass($config);
    }
}