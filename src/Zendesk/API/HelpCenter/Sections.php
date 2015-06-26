<?php
namespace Zendesk\API\HelpCenter;

use Zendesk\API\ClientAbstract;
use Zendesk\API\Http;
use Zendesk\API\MissingParametersException;
use Zendesk\API\ResponseException;

/**
 * The Sections class exposes section information
 * @package Zendesk\API
 */
class Sections extends ClientAbstract
{

    const OBJ_NAME = 'section';
    const OBJ_NAME_PLURAL = 'sections';

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
        $url = sprintf('help_center/sections/%d.json', $params['id']);
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
        $endPoint = Http::prepare('help_center/sections.json', $this->client->getSideload($params));
        $response = Http::send($this->client, $endPoint, $params);

        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 200)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);
        return $response;
    }

    /**
     * Create a new section
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
        if (!$this->hasKeys($params, array('category_id'))) {
            throw new MissingParametersException(__METHOD__, array('category_id'));
        }
        $url = sprintf('help_center/categories/%d/sections.json', $params['category_id']);
        $endPoint = Http::prepare($url);
        $response = Http::send($this->client, $endPoint, array(self::OBJ_NAME => $params), 'POST');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 201)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);

        return $response;
    }

    /**
     * Delete a section
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
        if (!$this->hasKeys($params, array('id'))) {
            throw new MissingParametersException(__METHOD__, array('id'));
        }
        $endPoint = Http::prepare('help_center/sections/' . $params['id'] . '.json');
        $response = Http::send($this->client, $endPoint, null, 'DELETE');
        if ($this->client->getDebug()->lastResponseCode != 200) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);

        return true;
    }
}
