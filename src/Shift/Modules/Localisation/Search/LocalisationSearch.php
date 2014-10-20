<?php namespace Tectonic\Shift\Modules\Localisation\Search;

use Tectonic\Shift\Library\Search\Search;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Modules\Localisation\Models\Localisation;

class LocalisationSearch extends Search
{

    private $keywordFilter;

    public function __construct(Localisation $localisation, KeywordFilter $keywordFilter, OrderFilter $orderFilter)
    {
        $this->setQuery($localisation);
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
