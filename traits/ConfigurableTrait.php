<?php
/**
 * ConfigurableTrait.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\traits;

/**
 * Class ConfigurableTrait
 * @package rmrevin\pivotal\traits
 */
trait ConfigurableTrait
{

    /**
     * ConfigurableTrait method.
     * @param object $object
     * @param array $config
     */
    public function configure($object, $config = [])
    {
        if (!empty($config)) {
            foreach ($config as $name => $value) {
                $object->$name = $value;
            }
        }
    }
}