<?php namespace Tectonic\Shift\Modules\Localisation\Search;

use Tectonic\Shift\Library\Search\Search;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Modules\Localisation\Models\Language;

class LocaleSearch extends Search
{

    private $keywordFilter;

    public function __construct(Language $locale, KeywordFilter $keywordFilter, OrderFilter $orderFilter)
    {
        $this->setQuery($locale);
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
