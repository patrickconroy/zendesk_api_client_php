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
class Categories extends ClientAbstract
{

    const OBJ_NAME = 'category';
    const OBJ_NAME_PLURAL = 'categories';

    /**
     * Find a specific article by id
     *
     * @param array $params
     *
     * @throws MissingParametersException
     * @throws ResponseException
     * @throws \Exception
     *
     * @return mixed
     */
    public function find(array $params = array())
    {
        if (!$this->hasKeys($params, array('id'))) {
            throw new MissingParametersException(__METHOD__, array('id'));
        }
        $url = sprintf('help_center/categories/%d.json', $params['id']);
        $endPoint = Http::prepare($url, $this->client->getSideload($params));
        $response = Http::send($this->client, $endPoint);

        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    public function findAll(array $params = array())
    {
        $endPoint = Http::prepare('help_center/categories.json', $this->client->getSideload($params));
        $response = Http::send($this->client, $endPoint);

        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    /**
     * Create a new category
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
        $endPoint = Http::prepare('help_center/categories.json');
        $response = Http::send($this->client, $endPoint, array(self::OBJ_NAME => $params), 'POST');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 201)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);

        return $response;
    }

    /**
     * Delete a category
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
        $endPoint = Http::prepare('help_center/categories/' . $params['id'] . '.json');
        $response = Http::send($this->client, $endPoint, null, 'DELETE');
        if ($this->client->getDebug()->lastResponseCode != 200) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);

        return true;
    }
}
