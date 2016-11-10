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
    }

    public function findAllInCategory(array $queryParams = [], $foo = null)
    {
        return $this->client->get($this->getRoute('findAllInCategory', $queryParams), $queryParams);
    }
}
