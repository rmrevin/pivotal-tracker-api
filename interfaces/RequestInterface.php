<?php
/**
 * RequestInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\interfaces;

/**
 * Interface RequestInterface
 * @package rmrevin\pivotal\interfaces
 */
interface RequestInterface
{

    /**
     * @param string $key
     * @param mixed $value
     * @return string
     */
    public function pushQuery($key, $value);

    /**
     * @return string
     */
    public function buildUrl();

    /**
     * @return static
     */
    public function createClone();

    /**
     * @return ResponseInterface
     */
    public function send();

    /**
     * @param array $config
     * @return ResponseInterface
     */
    public function createResponse($config = []);

    /**
     * @param array $config
     * @return ResponseInterface
     */
    public function createErrorResponse($config = []);
}