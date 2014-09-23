<?php namespace Tectonic\Shift\Modules\Localisation\Entities;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;

/**
 * Class Locale
 *
 * @ORM\Entity
 * @ORM\Table(name="`locales`")
 * @ExclusionPolicy("None")
 */
class Locale extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="`id`")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="string", name="`locale`") **/
    protected $locale;

    /**
     * @ORM\Column(type="string", name="`code`")
     **/
    protected $code;

	/**
	 * Initialise the locale entity. Locale and code are required.
	 *
	 * @param $locale
	 * @param $code
	 */
	public function __construct($locale, $code)
	{
		$this->locale = $locale;
		$this->code = $code;
	}
}
