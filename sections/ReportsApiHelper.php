<?php
/**
 * ReportsApiHelper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\sections;

use rmrevin\pivotal\ErrorResponse;
use rmrevin\pivotal\Response;

/**
 * Class ReportsApiHelper
 * @package rmrevin\pivotal\sections
 */
class ReportsApiHelper extends AbstractApi
{

    /**
     * @param integer $project_id
     * @param array $filter
     * @return Response|ErrorResponse
     */
    public function getProgress($project_id, $filter = [])
    {
        $query = [];

        if (isset($filter['after'])) {
            $query['occurred_after'] = $filter['after'];
        }

        if (isset($filter['occurred_after'])) {
            $query['occurred_after'] = $filter['occurred_after'];
        }

        if (isset($filter['before'])) {
            $query['occurred_before'] = $filter['before'];
        }

        if (isset($filter['occurred_before'])) {
            $query['occurred_before'] = $filter['occurred_before'];
        }

        if (isset($filter['features'])) {
            $query['features'] = $filter['features'];
        }

        if (isset($filter['bugs'])) {
            $query['bugs'] = $filter['bugs'];
        }

        if (isset($filter['chores'])) {
            $query['chores'] = $filter['chores'];
        }

        if (isset($filter['label'])) {
            $query['label'] = $filter['label'];
        }

        return $this->api->client->createRequest('GET', "reports/progress/projects/$project_id/stories", [
            'query' => $query,
        ])->send();
    }
}