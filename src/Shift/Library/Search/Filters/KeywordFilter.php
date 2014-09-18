<?php

namespace Tectonic\Shift\Library\Search\Filters;

class KeywordFilter implements SearchFilterInterface
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
	 * Keywords to search by.
	 *
	 * @var string
	 */
	private $keywords;

	/**
	 * @param $keywords
	 */
	private function __construct($keywords)
	{
		$this->keywords = $keywords;
	}

	/**
	 * Creates a new KeywordFilter from the keywords provided.
	 *
	 * @param $keywords
	 * @return static
	 */
	public static function fromKeywords($keywords)
	{
		return new static($keywords);
	}

	/**
	 * Applies the filter to the doctrine query builder.
	 *
	 * @param QueryBuilder $queryBuilder
	 */
	public function applyToDoctrine($queryBuilder)
	{
		if ($this->keywords) {
			$queryBuilder->andWhere($this->fieldName($queryBuilder).' LIKE :keywords');
			$queryBuilder->setParameter('keywords', '%'.$this->keywords.'%');
		}
	}

	/**
	 * Returns the field name to match against the keywords.
	 *
	 * @param $queryBuilder
	 * @return string
	 */
	public function fieldName($queryBuilder)
	{
		$rootAliases = $queryBuilder->getRootAliases();

		return $rootAliases[0].'.'.$this->defaultField;
	}
}
