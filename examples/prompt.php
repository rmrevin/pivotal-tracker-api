<?php
/**
 * prompt.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

class Prompt
{

    private $tty;

    /**
     * prompt constructor.
     */
    function __construct()
    {
        if (substr(PHP_OS, 0, 3) === 'WIN') {
            $this->tty = fopen('\con', 'rb');
        } elseif (!($this->tty = fopen('/dev/tty', 'r'))) {
            $this->tty = fopen('php://stdin', 'r');
        }
    }

    /**
     * @param $string
     * @param int $length
     * @return null|string
     */
    function get($string, $length = 1024)
    {
        $result = null;

        if (is_resource($this->tty)) {
            echo $string;
            $result = trim(fgets($this->tty, $length));
            echo "\n";
        }

        return $result;
    }
}