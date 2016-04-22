<?php
/**
 * ErrorResponse.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal;

/**
 * Class ErrorResponse
 * @package rmrevin\pivotal
 */
class ErrorResponse extends Response
{

    /** @var \Exception */
    public $_exception;
}