<?php
namespace Zendesk\API\HelpCenter;

use Zendesk\API\ClientAbstract;
use Zendesk\API\Http;
use Zendesk\API\MissingParametersException;
use Zendesk\API\ResponseException;

/**
 * The Articles class exposes article information
 * @package Zendesk\API
 */
class Articles extends ClientAbstract
{
    const OBJ_NAME = 'article';
    const OBJ_NAME_PLURAL = 'articles';

    /**
     * Find a specific article by id
     *
     * @param array $params
     *
     * @throws ResponseException
     * @throws \Exception
     *
     * @return mixed
     */
    public function find(array $params = [])
    {
        $url = sprintf(
            'help_center/%s%sarticles%s.json',
            isset($params['locale']) ? $params['locale'] . '/' : '',
            isset($params['section_id']) ? 'sections/' . $params['section_id'] . '/' : '',
            isset($params['id']) ? '/' . $params['id'] : ''
        );
        $endPoint = Http::prepare($url, $this->client->getSideload($params), isset($params['queryParams']) ? $params['queryParams'] : []);
        $response = Http::send($this->client, $endPoint);
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    public function search(array $params = [])
    {
        $endPoint = Http::prepare('help_center/articles/search.json', $this->client->getSideload($params));
        $response = Http::send($this->client, $endPoint, $params['queryParams']);
        $responseResults = (array)$response;
        if (isset($responseResults['results'])) {
            $response = json_decode(json_encode([
                self::OBJ_NAME_PLURAL => $response->results,
                'page' => $response->page,
                'previous_page' => $response->previous_page,
                'next_page' => $response->next_page,
                'page_count' => $response->page_count,
                'count' => $response->count,
                'per_page' => $response->per_page
            ]));
        }
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    public function findAll(array $params = array())
    {
        $endPoint = Http::prepare('help_center/articles.json', $this->client->getSideload($params), $params);
        $response = Http::send($this->client, $endPoint);

        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    /**
     * Create a new article
     *
     * @param array $params
     *
     * @throws ResponseException
     * @throws \Exception
     *
     * @return mixed
     */
    public function create(array $params)
    {
        if (!$this->hasKeys($params, array('section_id'))) {
            throw new MissingParametersException(__METHOD__, array('section_id'));
        }
        $url = sprintf('help_center/sections/%d/articles.json', $params['section_id']);
        $endPoint = Http::prepare($url);
        $response = Http::send($this->client, $endPoint, array(self::OBJ_NAME => $params), 'POST');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 201)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);

        return $response;
    }

    /**
     * Delete an article
     *
     * @param array $params
     *
     * @throws MissingParametersException
     * @throws ResponseException
     * @throws \Exception
     *
     * @return bool
     */
    public function delete(array $params = array())
    {
        if ($this->lastId != null) {
            $params['id'] = $this->lastId;
            $this->lastId = null;
        }
        if (!$this->hasKeys($params, array('id'))) {
            throw new MissingParametersException(__METHOD__, array('id'));
        }
        $endPoint = Http::prepare('help_center/articles/' . $params['id'] . '.json');
        $response = Http::send($this->client, $endPoint, null, 'DELETE');
        if ($this->client->getDebug()->lastResponseCode != 200) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);

        return true;
    }

    public function createComment(array $params)
    {
        if (!$this->hasKeys($params, ['article_id'])) {
            throw new MissingParametersException(__METHOD__, ['article_id']);
        }
        $url = sprintf('help_center/articles/%d/comments.json', $params['article_id']);
        unset($params['article_id']);
        $endPoint = Http::prepare($url);
        $response = Http::send($this->client, $endPoint, $params, 'POST');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 201)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);

        return $response;
    }

    public function findComments(array $params)
    {
        if (!$this->hasKeys($params, ['article_id'])) {
            throw new MissingParametersException(__METHOD__, ['article_id']);
        }
        $url = sprintf('help_center/articles/%d/comments.json', $params['article_id']);
        $endPoint = Http::prepare($url, $this->client->getSideload($params));
        $response = Http::send($this->client, $endPoint);
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }
}
