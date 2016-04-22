<?php
/**
 * MyApiHelper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\sections;

use rmrevin\pivotal\ErrorResponse;
use rmrevin\pivotal\ListResponse;
use rmrevin\pivotal\PaginationResponse;

/**
 * Class MyApiHelper
 * @package rmrevin\pivotal\sections
 */
class MyApiHelper extends AbstractApi
{

    /**
     * @param integer $limit
     * @return PaginationResponse|ErrorResponse
     */
    public function getActivityList($limit = 100)
    {
        return $this->api->client->createRequest('GET', 'my/activity', [
            'responseClass' => 'rmrevin\pivotal\PaginationResponse',
            'query' => ['limit' => $limit],
        ])->send();
    }

    /**
     * @return ListResponse|ErrorResponse
     */
    public function getNotificationsList()
    {
        return $this->api->client->createRequest('GET', 'my/notifications', [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
        ])->send();
    }

    /**
     * @return ListResponse|ErrorResponse
     */
    public function getWorkspacesList()
    {
        return $this->api->client->createRequest('GET', 'my/workspaces', [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
        ])->send();
    }
}