<?php
/**
 * EpicsApiHelper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\sections;

use rmrevin\pivotal\ErrorResponse;
use rmrevin\pivotal\ListResponse;
use rmrevin\pivotal\Response;

/**
 * Class EpicsApiHelper
 * @package rmrevin\pivotal\sections
 */
class EpicsApiHelper extends AbstractApi
{

    /**
     * @param integer $project_id
     * @param integer $epic_id
     * @return Response|ErrorResponse
     */
    public function getById($project_id, $epic_id)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/epics/$epic_id")->send();
    }

    /**
     * @param integer $project_id
     * @param string|null $filter
     * @return ListResponse|ErrorResponse
     */
    public function getList($project_id, $filter = null)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/epics", [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
            'query' => ['filter' => $filter],
        ])->send();
    }
}