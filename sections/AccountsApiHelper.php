<?php
/**
 * AccountsApiHelper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\sections;

use rmrevin\pivotal\ErrorResponse;
use rmrevin\pivotal\ListResponse;
use rmrevin\pivotal\Response;

/**
 * Class AccountsApiHelper
 * @package rmrevin\pivotal\sections
 */
class AccountsApiHelper extends AbstractApi
{

    /**
     * @param integer $account_id
     * @return Response|ErrorResponse
     */
    public function getById($account_id)
    {
        return $this->api->client->createRequest('GET', "accounts/$account_id")->send();
    }

    /**
     * @return ListResponse|ErrorResponse
     */
    public function getList()
    {
        return $this->api->client->createRequest('GET', 'accounts', [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
        ])->send();
    }

    /**
     * @param integer $account_id
     * @return ListResponse|ErrorResponse
     */
    public function getMembershipsList($account_id)
    {
        return $this->api->client->createRequest('GET', "accounts/$account_id/memberships", [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
        ])->send();
    }
}