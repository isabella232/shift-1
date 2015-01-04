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
     * @var
     */
    private $fields;

    /**
	 * @param $keywords
	 */
	private function __construct($keywords, $fields)
	{
		$this->keywords = $keywords;
        $this->fields = is_null($fields) ? $this->defaultField : $fields;
    }

	/**
	 * Creates a new KeywordFilter from the keywords provided.
	 *
	 * @param string $keywords
     * @param string|array $fields
	 * @return static
	 */
	public static function fromKeywords($keywords, $fields = null)
	{
		return new static($keywords, $fields);
	}

    /**
     * Apply the given search filter to an Eloquent query.
     *
     * @param $query
     * @return mixed
     */
    public function applyToEloquent($query)
    {
        if ($this->keywords) {
            if (!is_array($this->fields)) {
                $query = $query->where($this->fields, 'LIKE', '%' . $this->keywords . '%');
            }
            else {
                foreach ($this->fields as $field) {
                    $query = $query->where($field, 'LIKE', '%' . $this->keywords . '%');
                }
            }
        }

        return $query;
    }
}
