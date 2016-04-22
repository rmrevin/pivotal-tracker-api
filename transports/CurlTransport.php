<?php
/**
 * CurlTransport.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\transports;

use rmrevin\pivotal\API;
use rmrevin\pivotal\interfaces\RequestInterface;
use rmrevin\pivotal\interfaces\TransportInterface;

/**
 * Class CurlTransport
 * @package rmrevin\pivotal\transports
 */
class CurlTransport implements TransportInterface
{

    /** @var API */
    public $api;

    /** @var RequestInterface */
    public $request;

    /** @var callable[] */
    public $httpMiddleware = [];

    /**
     * @param callable $handler
     * @return static
     */
    public function pushMiddleware($handler)
    {
        if (is_callable($handler)) {
            $this->httpMiddleware[] = $handler;
        }

        return $this;
    }

    /**
     * @param RequestInterface $Request
     * @return static
     */
    public function capture(RequestInterface $Request)
    {
        $Transport = clone $this;
        $Transport->request = $Request;

        return $Transport;
    }

    /**
     * @inheritdoc
     */
    public function send($method, $url)
    {
        $Client = $this->api->client;
        $Request = $this->request;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [sprintf('X-TrackerToken: %s', $Client->getApiToken())]);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if (!empty($this->httpMiddleware)) {
            foreach ($this->httpMiddleware as $handler) {
                if (is_callable($handler)) {
                    call_user_func($handler, $ch);
                }
            }
        }

        $body = curl_exec($ch);

        if (curl_errno($ch) > 0) {
            $Response = $Request->createErrorResponse([
                'api' => $this->api,
                'request' => $Request,
                '_exception' => new \Exception(curl_error($ch)),
            ]);
        } else {
            $headers = [];
            $response = '';

            $lines = explode("\r\n", $body);

            $currentHeaders = true;

            if (!empty($lines)) {
                foreach ($lines as $line) {
                    if ($currentHeaders) {
                        if (empty($line)) {
                            $currentHeaders = false;
                            continue;
                        }

                        $headers[] = $line;
                    } else {
                        $response .= $line . "\r\n";
                    }
                }
            }

            $Response = $Request->createResponse([
                'api' => $this->api,
                'request' => $Request,
                'headers' => $this->prepareHeaders($headers),
                '_data' => json_decode($response, true),
            ]);
        }

        curl_close($ch);

        return $Response;
    }

    /**
     * @param array $headers
     * @return array
     */
    protected function prepareHeaders(array $headers)
    {
        $result = [];

        if (!empty($headers)) {
            foreach ($headers as $header) {
                @list($key, $value) = explode(':', $header);

                $result[$key] = empty($value) ? [] : [trim($value)];
            }
        }

        return $result;
    }

    /**
     * @return API
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param API $API
     */
    public function setApi(API $API)
    {
        $this->api = $API;
    }
}