<?php
/**
 * ClientInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\interfaces;

use rmrevin\pivotal\API;

/**
 * Interface ClientInterface
 * @package rmrevin\pivotal\interfaces
 */
interface ClientInterface
{

    /**
     * @param string $method
     * @param string $command
     * @param array $config
     * @return RequestInterface
     */
    public function createRequest($method, $command, array $config = []);

    /**
     * @return API
     */
    public function getApi();

    /**
     * @param API $API
     */
    public function setApi(API $API);

    /**
     * @return string
     */
    public function getApiUrl();

    /**
     * @return string|null
     */
    public function getApiToken();

}