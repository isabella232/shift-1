<?php namespace Tectonic\Shift\Modules\CustomFields\Search;

use Tectonic\Shift\Library\Search\Filters\OrderFilter;
use Tectonic\Shift\Library\Search\Search;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Modules\CustomFields\Models\CustomField;

class CustomFieldSearch extends Search
{

    private $keywordFilter;

    public function __construct(CustomField $customField, KeywordFilter $keywordFilter, OrderFilter $orderFilter)
    {
        $this->setQuery($customField);
        $this->orderFilter = $orderFilter;
        $this->keywordFilter = $keywordFilter;

        $this->registerFilters();
    }

    public function registerFilters()
    {
        $this->addFilter($this->orderFilter);
        $this->addFilter($this->keywordFilter);
    }
}
