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
     * @ORM\ManyToMany(targetEntity="Tectonic\Shift\Modules\Accounts\Entities\Account", mappedBy="locales")
     */
    protected $accounts;

}
