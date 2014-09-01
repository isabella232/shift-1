<?php

namespace Tectonic\Shift\Library\Search\Filters;

use Tectonic\Shift\Library\Search\Filters\SearchFilterInterface;
use Tectonic\Shift\Library\Search\Search;

class KeywordFilter extends SearchFilter implements SearchFilterInterface
{	
	/**
	 * Default field for keyword searches. For most resources, which are quite basic,
	 * the field "name" is common, and so is used frequently. It's also the standard
	 * field name for "name" like fields, such as title, topic.etc.
	 * 
	 * @var string
	 */
	public $defaultField = 'name';

	/**
	 * Simply checks the default field for the given keyword.
	 */
	public function criteria()
	{
		if ($this->hasParam('keyword')) {
			$this->getQuery()->where($this->defaultField, 'LIKE', '%' . $this->getParam('keyword') . '%');
		}
	}
}