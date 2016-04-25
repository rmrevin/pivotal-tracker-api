<?php
/**
 * StoriesApiHelper.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal\sections;

use rmrevin\pivotal\ErrorResponse;
use rmrevin\pivotal\ListResponse;
use rmrevin\pivotal\PaginationResponse;
use rmrevin\pivotal\Response;

/**
 * Class StoriesApiHelper
 * @package rmrevin\pivotal\sections
 */
class StoriesApiHelper extends AbstractApi
{

    /**
     * @param integer $project_id
     * @param integer $story_id
     * @return Response|ErrorResponse
     */
    public function getById($project_id, $story_id)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/stories/$story_id")->send();
    }

    /**
     * @param integer $project_id
     * @param array $filter
     * @param integer $limit
     * @return PaginationResponse|ErrorResponse
     */
    public function getList($project_id, $filter = [], $limit = 25)
    {
        $query = ['limit' => $limit];

        if (isset($filter['filter'])) {
            $query['filter'] = $filter['filter'];
        }

        if (isset($filter['with_label'])) {
            $query['with_label'] = $filter['with_label'];
        }

        if (isset($filter['with_story_type'])) {
            $query['with_story_type'] = $filter['with_story_type'];
        }

        if (isset($filter['with_state'])) {
            $query['with_state'] = $filter['with_state'];
        }

        if (isset($filter['after_story_id'])) {
            $query['after_story_id'] = $filter['after_story_id'];
        }

        if (isset($filter['before_story_id'])) {
            $query['before_story_id'] = $filter['before_story_id'];
        }

        if (isset($filter['accepted_before'])) {
            $query['accepted_before'] = $filter['accepted_before'];
        }

        if (isset($filter['accepted_after'])) {
            $query['accepted_after'] = $filter['accepted_after'];
        }

        if (isset($filter['created_before'])) {
            $query['created_before'] = $filter['created_before'];
        }

        if (isset($filter['created_after'])) {
            $query['created_after'] = $filter['created_after'];
        }

        if (isset($filter['updated_before'])) {
            $query['updated_before'] = $filter['updated_before'];
        }

        if (isset($filter['updated_after'])) {
            $query['updated_after'] = $filter['updated_after'];
        }

        if (isset($filter['deadline_before'])) {
            $query['deadline_before'] = $filter['deadline_before'];
        }

        if (isset($filter['deadline_after'])) {
            $query['deadline_after'] = $filter['deadline_after'];
        }

        return $this->api->client->createRequest('GET', "projects/$project_id/stories", [
            'responseClass' => 'rmrevin\pivotal\PaginationResponse',
            'query' => $query,
        ])->send();
    }

    /**
     * @param integer $project_id
     * @param integer $story_id
     * @return ListResponse|ErrorResponse
     */
    public function getStoryTaskList($project_id, $story_id)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/stories/$story_id/tasks", [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
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
     * @param integer $story_id
     * @return ListResponse|ErrorResponse
     */
    public function getCommentsList($project_id, $story_id)
    {
        return $this->api->client->createRequest('GET', "projects/$project_id/stories/$story_id/comments", [
            'responseClass' => 'rmrevin\pivotal\ListResponse',
        ])->send();
    }
}