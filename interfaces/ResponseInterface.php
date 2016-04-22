<?php
/**
 * ResponseInterface.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\interfaces;

/**
 * Interface ResponseInterface
 * @package rmrevin\pivotal\interfaces
 */
interface ResponseInterface
{

    /**
     * @return array
     */
    public function getData();

    /**
     * @return array
     */
    public function getHeaders();
}