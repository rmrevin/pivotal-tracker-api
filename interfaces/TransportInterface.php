<?php
/**
 * TransportInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\interfaces;

use rmrevin\pivotal\API;

/**
 * Interface TransportInterface
 * @package rmrevin\pivotal\interfaces
 */
interface TransportInterface
{

    /**
     * @return API
     */
    public function getApi();

    /**
     * @param API $API
     */
    public function setApi(API $API);

    /**
     * @param callable $handler
     * @return static
     */
    public function pushMiddleware($handler);

    /**
     * @param RequestInterface $Request
     * @return static
     */
    public function capture(RequestInterface $Request);

    /**
     * @param string $method
     * @param string $url
     * @return ResponseInterface
     */
    public function send($method, $url);
}