<?php

namespace Zendesk\API\Resources\HelpCenter;

use Zendesk\API\Exceptions\RouteException;
use Zendesk\API\Traits\Resource\Defaults;
use Zendesk\API\Traits\Resource\Locales;

/**
 * Class Articles
 * https://developer.zendesk.com/rest_api/docs/help_center/articles
 */
class Articles extends ResourceAbstract
{
    use Defaults;
    use Locales;

    /**
     * @{inheritdoc}
     */
    protected $objectName = 'article';

    /**
     * @{inheritdoc}
     */
    protected function setupRoutes()
    {
        parent::setUpRoutes();
        $this->setRoutes([
            'bulkAttach' => "$this->resourceName/{articleId}/bulk_attachments.json",
            'updateSourceLocale' => "$this->resourceName/{articleId}/source_locale.json",
            'create' => "{$this->prefix}sections/{section_id}/articles.json",
            'findAllInSection' => "{$this->prefix}sections/{section_id}/articles.json",
            'subscribe' => "{$this->resourceName}/{article_id}/subscriptions.json",
            'getSubscription' => "{$this->resourceName}/{article_id}/subscriptions.json",
            'unsubscribe' => "{$this->resourceName}/{article_id}/subscriptions/{subscription_id}.json",
            'search' => "{$this->resourceName}/search.json",
            'createTranslation' => "{$this->resourceName}/{article_id}/translations.json"
        ]);
    }

    /**
     * Bulk upload attachments to a specified article
     *
     * @param int    $articleId The article to update
     * @param array  $params    An array of attachment ids
     * @param string $routeKey  The route to set
     * @return null|\stdClass
     * @throws \Exception
     */
    public function bulkAttach($articleId, array $params, $routeKey = __FUNCTION__)
    {
        try {
            $route = $this->getRoute($routeKey, ['articleId' => $articleId]);
        } catch (RouteException $e) {
            if (! isset($this->resourceName)) {
                $this->resourceName = $this->getResourceNameFromClass();
            }

            $route = $this->resourceName . '.json';
            $this->setRoute(__FUNCTION__, $route);
        }
        return $this->client->post(
            $route,
            ['attachment_ids' => $params]
        );
    }

    public function findAllInSection(array $queryParams = [])
    {
        return $this->client->get($this->getRoute('findAllInSection', $queryParams), $queryParams);
    }

    public function subscribe(array $queryParams = [])
    {
        return $this->client->post($this->getRoute('subscribe', $queryParams), $queryParams);
    }

    public function getSubscription(array $queryParams = [])
    {
        return $this->client->get($this->getRoute('getSubscription', $queryParams), $queryParams);
    }

    public function unsubscribe(array $queryParams = [])
    {
        return $this->client->delete($this->getRoute('unsubscribe', $queryParams), $queryParams);
    }

    public function search(array $queryParams = [])
    {
        return $this->client->get($this->getRoute('search', $queryParams), $queryParams);
    }

    public function createTranslation(array $queryParams = [])
    {
        return $this->client->post($this->getRoute('createTranslation', $queryParams), $queryParams);
    }
}
