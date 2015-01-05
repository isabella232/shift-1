<?php
namespace Tectonic\Shift\Modules\Identity\Users\Search;

use Tectonic\Shift\Modules\Accounts\Models\User;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;

class UserSearch extends \Tectonic\Shift\Library\Search\Search
{
	private $keywordFilter;

	private $orderFilter;

	public function __construct(KeywordFilter $keywordFilter, OrderFilter $orderFilter)
	{
		$this->keywordFilter = $keywordFilter;
		$this->orderFilter = $orderFilter;

		$this->registerFilters();
	}

	public function registerFilters()
	{
        $this->addFilter($this->orderFilter);
        $this->addFilter($this->keywordFilter);
    }
}
