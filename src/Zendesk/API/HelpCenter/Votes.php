<?php
namespace Zendesk\API\HelpCenter;

use Zendesk\API\ClientAbstract;
use Zendesk\API\Http;
use Zendesk\API\MissingParametersException;
use Zendesk\API\ResponseException;

/**
 * The Votes class exposes article information
 * @package Zendesk\API
 */
class Votes extends ClientAbstract
{

    const OBJ_NAME = 'vote';
    const OBJ_NAME_PLURAL = 'votes';

    /**
     * Find a specific vote group by article_id
     *
     * @param array $params
     *
     * @throws MissingParametersException
     * @throws ResponseException
     * @throws \Exception
     *
     * @return mixed
     */
    public function find(array $params = [])
    {
        if (!$this->hasKeys($params, ['article_id'])) {
            throw new MissingParametersException(__METHOD__, ['article_id']);
        }
        $url = sprintf('help_center/articles/%d/votes.json', $params['article_id']);
        $endPoint = Http::prepare($url, $this->client->getSideload($params));
        $response = Http::send($this->client, $endPoint);
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    public function create($params)
    {
        if (!$this->hasKeys($params, ['article_id', 'direction'])) {
            throw new MissingParametersException(__METHOD__, ['article_id', 'direction']);
        }
        $url = sprintf('help_center/articles/%d/%s.json', $params['article_id'], $params['direction']);
        $endPoint = Http::prepare($url, $this->client->getSideload($params));
        $response = Http::send($this->client, $endPoint, null, 'POST');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }
}
