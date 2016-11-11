<?php

namespace Zendesk\API\Resources\HelpCenter;

use Zendesk\API\Traits\Resource\Defaults;
use Zendesk\API\Traits\Resource\Locales;
/**
 * Class Categories
 * https://developer.zendesk.com/rest_api/docs/help_center/categories
 */
class Sections extends ResourceAbstract
{

    use Defaults;
    use Locales;
    /**
     * {@inheritdoc}
     */
    protected $objectName = 'section';

    /**
     * @inheritdoc
     */
    protected function setUpRoutes()
    {
        $this->setRoute('updateSourceLocale', "{$this->resourceName}/{categoryId}/source_locale.json");
        $this->setRoute('create', "{$this->prefix}categories/{category_id}/sections.json");
        $this->setRoute('findAll', "{$this->prefix}/sections.json");
        $this->setRoute('findAllInCategory', "{$this->prefix}categories/{category_id}/sections.json");

        $this->setRoute('subscribe', "{$this->resourceName}/{section_id}/subscriptions.json");
        $this->setRoute('getSubscription', "{$this->resourceName}/{section_id}/subscriptions.json");
        $this->setRoute('unsubscribe', "{$this->resourceName}/{section_id}/subscriptions/{subscription_id}.json");
    }

    public function findAllInCategory(array $queryParams = [], $foo = null)
    {
        return $this->client->get($this->getRoute('findAllInCategory', $queryParams), $queryParams);
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
}
