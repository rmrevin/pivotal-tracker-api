<?php
/**
 * API.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal;

use rmrevin\pivotal\interfaces\ClientInterface;
use rmrevin\pivotal\interfaces\RequestInterface;
use rmrevin\pivotal\interfaces\TransportInterface;
use rmrevin\pivotal\sections\AccountsApiHelper;
use rmrevin\pivotal\sections\MyApiHelper;
use rmrevin\pivotal\sections\ProjectsApiHelper;
use rmrevin\pivotal\sections\ReportsApiHelper;

/**
 * Class API
 * @package rmrevin\pivotal
 */
class API
{

    /** @var ClientInterface */
    public $client;

    /** @var TransportInterface */
    public $transport;

    /**
     * API constructor.
     * @param ClientInterface $Client
     * @param TransportInterface $Transport
     */
    public function __construct(ClientInterface $Client, TransportInterface $Transport)
    {
        $Client->setApi($this);
        $Transport->setApi($this);

        $this->client = $Client;
        $this->transport = $Transport;
    }

    /**
     * @return Response
     */
    public function me()
    {
        return $this->client->createRequest('GET', 'me')->send();
    }

    /**
     * @return AccountsApiHelper
     */
    public function accounts()
    {
        return new AccountsApiHelper(['api' => $this]);
    }

    /**
     * @return ProjectsApiHelper
     */
    public function projects()
    {
        return new ProjectsApiHelper(['api' => $this]);
    }

    /**
     * @return MyApiHelper
     */
    public function my()
    {
        return new MyApiHelper(['api' => $this]);
    }

    /**
     * @return ReportsApiHelper
     */
    public function reports()
    {
        return new ReportsApiHelper(['api' => $this]);
    }
}