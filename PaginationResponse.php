<?php
/**
 * PaginationResponse.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\pivotal;

use rmrevin\pivotal\interfaces\ResponseInterface;

/**
 * Class PaginationResponse
 * @package rmrevin\pivotal
 */
class PaginationResponse extends ListResponse implements ResponseInterface
{

    public $pagination;

    /**
     * PaginationResponse constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $headers = $this->headers;

        $this->pagination = [
            'total' => isset($headers['X-Tracker-Pagination-Total']) ? $headers['X-Tracker-Pagination-Total'] : 0,
            'limit' => isset($headers['X-Tracker-Pagination-Limit']) ? $headers['X-Tracker-Pagination-Limit'] : 0,
            'offset' => isset($headers['X-Tracker-Pagination-Offset']) ? $headers['X-Tracker-Pagination-Offset'] : 0,
            'returned' => isset($headers['X-Tracker-Pagination-Returned']) ? $headers['X-Tracker-Pagination-Returned'] : 0,
        ];
    }

    /**
     * @return bool
     */
    public function nextPageExists()
    {
        $pagination = $this->pagination;

        return ($pagination['offset'] + $pagination['limit']) < $pagination['total'];
    }

    /**
     * @return bool
     */
    public function prevPageExists()
    {
        $pagination = $this->pagination;

        return ($pagination['offset'] - $pagination['limit']) >= 0;
    }

    /**
     * @return ListResponse|false
     */
    public function nextPage()
    {
        $result = false;

        if ($this->nextPageExists()) {
            $pagination = $this->pagination;

            $offset = $pagination['offset'] + $pagination['limit'];
            $offset = $offset > $pagination['total'] ? $pagination['total'] : $offset;

            $Request = $this->request->createClone();
            $Request->pushQuery('offset', $offset);
            $Request->pushQuery('limit', $pagination['limit']);

            $result = $Request->send();
        }

        return $result;
    }

    /**
     * @return ListResponse|false
     */
    public function prevPage()
    {
        $result = false;

        if ($this->prevPageExists()) {
            $pagination = $this->pagination;

            $offset = $pagination['offset'] - $pagination['limit'];
            $offset = $offset <= 0 ? 0 : $offset;

            $Request = $this->request->createClone();
            $Request->pushQuery('offset', $offset);
            $Request->pushQuery('limit', $pagination['limit']);

            $result = $Request->send();
        }

        return $result;
    }
}