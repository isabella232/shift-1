<?php namespace Tectonic\Shift\Modules\CustomFields\Search;

use Tectonic\Shift\Library\Search\Search;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;

class CustomFieldSearch extends Search
{

    private $keywordFilter;

    public function __construct(KeywordFilter $keywordFilter)
    {
        $this->keywordFilter = $keywordFilter;

        $this->registerFilters();
    }

    protected function registerFilters()
    {
        $this->addFilter($this->keywordFilter);
    }
}
