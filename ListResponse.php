<?php
/**
 * ListResponse.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal;

use rmrevin\pivotal\interfaces\ResponseInterface;

/**
 * Class ListResponse
 * @package rmrevin\pivotal
 */
class ListResponse extends Response implements ResponseInterface
{

    /**
     * @param callable $handler
     */
    public function itemIterator($handler)
    {
        if (is_array($this->_data) && !empty($this->_data)) {
            foreach ($this->_data as $key => $item) {
                if (is_callable($handler)) {
                    call_user_func($handler, $item, $key);
                }
            }
        }
    }
}