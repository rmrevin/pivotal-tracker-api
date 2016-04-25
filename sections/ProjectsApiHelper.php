<?php
/**
 * ProjectsApiHelper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\sections;

use rmrevin\pivotal\ErrorResponse;
use rmrevin\pivotal\ListResponse;
use rmrevin\pivotal\PaginationResponse;
use rmrevin\pivotal\Response;

/**
 * Class ProjectsApiHelper
 * @package rmrevin\pivotal\sections
 */
class ProjectsApiHelper extends AbstractApi
{

    /**
     * @return EpicsApiHelper
     */
    public function epics()
    {
        return new EpicsApiHelper(['api' => $this->api]);
    }


    /**
     * @return StoriesApiHelper
     */
    public function stories()
    {
        return new StoriesApiHelper(['api' => $this->api]);
    }

    /**
     * @param integer $project_id
     * @return Response|ErrorResponse
     */
    public function getById($project_id)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id")->send();
    }

    /**
     * @return ListResponse|ErrorResponse
     */
    public function getList()
    {
        return $this->api->client->createRequest('GET', 'projects', [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
        ])->send();
    }

    /**
     * @param integer $project_id
     * @param int $limit
     * @return PaginationResponse|ErrorResponse
     */
    public function getIterationsList($project_id, $limit = 10)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/iterations", [
            'responseClass' => 'rmrevin\pivotal\PaginationResponse',
            'query' => ['limit' => $limit],
        ])->send();
    }

    /**
     * @param integer $project_id
     * @return ListResponse|ErrorResponse
     */
    public function getLabelsList($project_id)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/labels", [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
        ])->send();
    }

    /**
     * @param integer $project_id
     * @param string $query
     * @return ListResponse|ErrorResponse
     */
    public function getSearch($project_id, $query)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/search", [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
            'query' => ['query' => $query],
        ])->send();
    }

    /**
     * @param integer $project_id
     * @param array $filter
     * @return ListResponse|ErrorResponse
     */
    public function getHistoryList($project_id, $filter = [])
    {
        $query = [];

        if (isset($filter['start_date'])) {
            $query['start_date'] = $filter['start_date'];
        }

        if (isset($filter['end_date'])) {
            $query['end_date'] = $filter['end_date'];
        }

        if (isset($filter['label'])) {
            $query['label'] = $filter['label'];
        }

        return $this->api->client->createRequest('GET', "projects/$project_id/history/days", [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
            'query' => $query,
        ])->send();
    }

    /**
     * @param integer $project_id
     * @param array $filter
     * @param integer $limit
     * @return PaginationResponse|ErrorResponse
     */
    public function getStoryTransitionsList($project_id, $filter = [], $limit = 100)
    {
        $query = ['limit' => $limit];

        if (isset($filter['after'])) {
            $query['occurred_after'] = $filter['after'];
        }

        if (isset($filter['occurred_after'])) {
            $query['occurred_after'] = $filter['occurred_after'];
        }

        if (isset($filter['before'])) {
            $query['occurred_before'] = $filter['before'];
        }

        if (isset($filter['occurred_after'])) {
            $query['occurred_before'] = $filter['occurred_before'];
        }

        return $this->api->client->createRequest('GET', "projects/$project_id/story_transitions", [
            'responseClass' => 'rmrevin\pivotal\PaginationResponse',
            'query' => $query,
        ])->send();

    }

    /**
     * @param integer $project_id
     * @return ListResponse|ErrorResponse
     */
    public function getIntegrationsList($project_id)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/integrations", [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
        ])->send();
    }

    /**
     * @param integer $project_id
     * @return ListResponse|ErrorResponse
     */
    public function getMembershipsList($project_id)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/memberships", [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
        ])->send();
    }

    /**
     * @param integer $project_id
     * @return ListResponse|ErrorResponse
     */
    public function getWebhooksList($project_id)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/webhooks", [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
        ])->send();
    }
}