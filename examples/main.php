<?php
/**
 * main.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

use rmrevin\pivotal\API;
use rmrevin\pivotal\Client;
use rmrevin\pivotal\ErrorResponse;
use rmrevin\pivotal\transports\CurlTransport;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/prompt.php';

$defaultToken = file_exists(__DIR__ . '/.token')
    ? file_get_contents(__DIR__ . '/.token')
    : null;

/**
 * Pivotal Tracker api token
 * @link https://www.pivotaltracker.com/profile
 */
$token = (new prompt)
    ->get(sprintf('Enter your Pivotal Tracker Api token%s: ', empty($defaultToken) ? null : (' [' . $defaultToken . ']')));

$token = empty($token) ? $defaultToken : $token;

if (empty($token)) {
    throw new \RuntimeException('Empty api token');
}

$Client = new Client([
    'apiToken' => $token,
]);

$Transport = new CurlTransport;
//or $Transport = new GuzzleTransport;

$Api = new API($Client, $Transport);

$Response = $Api->me();

if ($Response instanceof ErrorResponse) {
    print_r($Response->_exception);
} else {
    print_r($Response->getData());
}
