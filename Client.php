<?php
/**
 * Client.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal;

use rmrevin\pivotal\exceptions\InvalidCallException;
use rmrevin\pivotal\exceptions\InvalidParamException;
use rmrevin\pivotal\traits\ConfigurableTrait;

/**
 * Class Client
 * @package rmrevin\pivotal
 */
class Client implements interfaces\ClientInterface
{

    use ConfigurableTrait;

    /** @var API */
    public $api;

    /** @var string */
    public $apiUrl = 'https://www.pivotaltracker.com/services/v5';

    /** @var string|null */
    public $apiToken = null;

    /** @var string */
    public $requestClass = 'rmrevin\pivotal\Request';

    /**
     * Client constructor.
     * @param array $config
     * @throws InvalidCallException
     * @throws InvalidParamException
     */
    public function __construct($config = [])
    {
        $this->configure($this, $config);

        if (empty($this->apiToken)) {
            throw new InvalidParamException('Empty api token.');
        }

        if (empty($this->requestClass)) {
            throw new InvalidParamException('Empty request class.');
        } elseif (!class_exists($this->requestClass)) {
            throw new InvalidCallException('Request class not found.');
        }
    }

    /**
     * @inheritdoc
     */
    public function createRequest($method, $command, array $config = [])
    {
        $class = $this->requestClass;

        if (!class_exists($class)) {
            throw new exceptions\InvalidCallException(sprintf('Class `%s` not found.', $class));
        }

        $config = array_merge([
            'api' => $this->api,
            'method' => $method,
            'command' => trim($command, " \t\n\r/"),
        ], $config);

        return new $class($config);
    }

    /**
     * @return API
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param API $API
     */
    public function setApi(API $API)
    {
        $this->api = $API;
    }

    /**
     * @inheritdoc
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @inheritdoc
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }
}