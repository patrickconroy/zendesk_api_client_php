<?php
namespace Zendesk\API\HelpCenter;

use Cake\Core\Configure;
use Zendesk\API\ClientAbstract;
use Zendesk\API\Http;
use Zendesk\API\MissingParametersException;
use Zendesk\API\ResponseException;

/**
 * The Articles class exposes article information
 * @package Zendesk\API
 */
class ArticleSubscriptions extends ClientAbstract
{
    const OBJ_NAME = 'subscription';
    const OBJ_NAME_PLURAL = 'subscriptions';


    /**
     * Finds an article subscription
     *
     * @param array $params The params
     * @return mixed
     */
    public function find(array $params)
    {
        if (!$this->hasKeys($params, ['article_id'])) {
            throw new MissingParametersException(__METHOD__, ['article_id']);
        }
        $url = sprintf('help_center/articles/%d/subscriptions.json', $params['article_id']);
        $endPoint = Http::prepare($url);
        $response = Http::send($this->client, $endPoint, null, 'GET');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    /**
     * Create a new article subscription
     *
     * @param array $params The params
     *
     * @throws ResponseException
     * @throws \Exception
     * @return mixed
     */
    public function create(array $params)
    {
        if (!$this->hasKeys($params, ['article_id', 'subscription'])) {
            throw new MissingParametersException(__METHOD__, ['article_id', 'subscription']);
        }
        $url = sprintf('help_center/articles/%d/subscriptions.json', $params['article_id']);
        $endPoint = Http::prepare($url);
        $response = Http::send($this->client, $endPoint, [self::OBJ_NAME => $params['subscription']], 'POST');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 201)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    /**
     * Delete an article subscription
     *
     * @throws ResponseException
     * @throws \Exception
     * @return mixed
     */
    public function delete(array $params)
    {
        if (!$this->hasKeys($params, ['article_id', 'id'])) {
            throw new MissingParametersException(__METHOD__, ['article_id', 'id']);
        }
        $url = sprintf('help_center/articles/%d/subscriptions/%d.json', $params['article_id'], $params['id']);
        $endPoint = Http::prepare($url);
        $response = Http::send($this->client, $endPoint, null, 'DELETE');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 201)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }
}
