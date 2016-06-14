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
class Translations extends ClientAbstract
{

    const OBJ_NAME = 'translation';
    const OBJ_NAME_PLURAL = 'translations';

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
        if (!$this->hasKeys($params, ['type', 'foreignKey'])) {
            throw new MissingParametersException(__METHOD__, ['type', 'foreignKey']);
        }
        $url = sprintf('help_center/%s/%d/translations.json', $params['type'], $params['foreignKey']);
        $endPoint = Http::prepare($url);
        $response = Http::send($this->client, $endPoint, [self::OBJ_NAME => $params[self::OBJ_NAME]], 'POST');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 201)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);

        return $response;
    }

    public function update(array $params)
    {
        if (!$this->hasKeys($params, ['type', 'foreignKey', 'locale'])) {
            throw new MissingParametersException(__METHOD__, ['type', 'foreignKey', 'locale']);
        }
        $url = sprintf('help_center/%s/%d/translations/%s.json', $params['type'], $params['foreignKey'], $params['locale']);
        $endPoint = Http::prepare($url);
        $response = Http::send($this->client, $endPoint, [self::OBJ_NAME => $params[self::OBJ_NAME]], 'PUT');
        if ((!is_object($response)) || ($this->client->getDebug()->lastResponseCode != 201)) {
            throw new ResponseException(__METHOD__);
        }
        $this->client->setSideload(null);

        return $response;
    }
}
