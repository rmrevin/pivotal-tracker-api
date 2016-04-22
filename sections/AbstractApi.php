<?php
/**
 * AbstractApi.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\sections;

use rmrevin\pivotal\API;
use rmrevin\pivotal\traits\ConfigurableTrait;

/**
 * Class AbstractApi
 * @package rmrevin\pivotal\sections
 */
abstract class AbstractApi
{

    use ConfigurableTrait;

    /** @var API */
    public $api;

    /**
     * AbstractApi constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->configure($this, $config);
    }
}