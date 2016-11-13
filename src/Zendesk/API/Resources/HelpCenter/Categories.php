<?php

namespace Zendesk\API\Resources\HelpCenter;

use Zendesk\API\Traits\Resource\Defaults;
use Zendesk\API\Traits\Resource\Locales;

/**
 * Class Categories
 * https://developer.zendesk.com/rest_api/docs/help_center/categories
 */
class Categories extends ResourceAbstract
{
    use Defaults;
    use Locales;

    /**
     * {@inheritdoc}
     */
    protected $objectName = 'category';

    /**
     * @inheritdoc
     */
    protected function setUpRoutes()
    {
        $this->setRoute('updateSourceLocale', "{$this->resourceName}/{categoryId}/source_locale.json");
        $this->setRoute('createTranslation', "{$this->resourceName}/{category_id}/translations.json");
        $this->setRoute('getTranslations', "{$this->resourceName}/{category_id}/translations.json");
    }

    public function createTranslation(array $queryParams = [])
    {
        return $this->client->post($this->getRoute('createTranslation', $queryParams), $queryParams);
    }

    public function getTranslations(array $queryParams = [])
    {
        return $this->client->get($this->getRoute('getTranslations', $queryParams), $queryParams);
    }
}
