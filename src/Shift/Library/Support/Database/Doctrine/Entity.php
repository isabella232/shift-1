<?php namespace Tectonic\Shift\Library\Support\Database\Doctrine;

use BadMethodCallException;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class Entity
 *
 * @Annotation
 * @ORM\MappedSuperclass
 * @package Tectonic\Shift\Library\Support\Database\Doctrine
 */
class Entity implements Jsonable
{
    /**
     * If a given property exists, then let's support a getter for that property.
     *
     * @param $method
     * @param array $arguments
     * @throws BadMethodCallException
     */
    public function __call($method, array $arguments = [])
    {
        $methodPossibility = substr($method, 0, 3);
        $property = camel_case(substr($method, 3));

        if (property_exists($this, $property)) {
            switch ($methodPossibility) {
                case 'get':
                    return $this->$property;
                    break;
                case 'set':
                    $this->$property = array_pop($arguments);
                    return;
                    break;
            }
        }

        throw new BadMethodCallException(static::class.'::'.$method.' does not exist.');
    }

	/**
	 * This is just a shorthand method, for now. This will need to be removed, and instead - all our responses via entities
	 * sent to an entity transformer for each resource that can handle how data is returned as part of the response.
	 *
	 * @param int $options
	 * @return string
	 */
	public function toJson($options = 0)
	{
		return json_encode(get_object_vars($this), $options);
	}
}
