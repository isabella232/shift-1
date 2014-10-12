<?php namespace Tectonic\Shift\Modules\Fields\Search;

use Tectonic\Shift\Library\Search\Search;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Modules\Fields\Entities\Field;

class FieldSearch extends Search
{

    private $keywordFilter;

    public function __construct(Field $customField, KeywordFilter $keywordFilter, OrderFilter $orderFilter)
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
