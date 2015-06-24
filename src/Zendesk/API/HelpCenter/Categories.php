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
}
