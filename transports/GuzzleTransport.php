<?php
/**
 * GuzzleTransport.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\transports;

use Psr\Http\Message\ResponseInterface;
use rmrevin\pivotal\API;
use rmrevin\pivotal\interfaces\RequestInterface;
use rmrevin\pivotal\interfaces\TransportInterface;
use rmrevin\pivotal\traits\ConfigurableTrait;

/**
 * Class GuzzleTransport
 * @package rmrevin\pivotal\transports
 */
class GuzzleTransport implements TransportInterface
{

    use ConfigurableTrait;

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

        $HttpClient = new \GuzzleHttp\Client;

        $HttpRequest = new \GuzzleHttp\Psr7\Request($method, $url, [
            'X-TrackerToken' => $Client->getApiToken(),
        ]);

        if (!empty($this->httpMiddleware)) {
            foreach ($this->httpMiddleware as $handler) {
                if (is_callable($handler)) {
                    call_user_func($handler, $HttpClient, $HttpRequest);
                }
            }
        }

        try {
            /** @var ResponseInterface $HttpResponse */
            $HttpResponse = $HttpClient->send($HttpRequest);

            $response = $HttpResponse->getBody();

            $headers = $HttpResponse->getHeaders();

            $Response = $Request->createResponse([
                'client' => $Client,
                'request' => $Request,
                'transport' => $this,
                'headers' => $headers,
                '_data' => json_decode($response),
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $Response = $Request->createErrorResponse([
                'client' => $Client,
                'request' => $Request,
                'transport' => $this,
                '_exception' => $e,
            ]);
        }

        return $Response;
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