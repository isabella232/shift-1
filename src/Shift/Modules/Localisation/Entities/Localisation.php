<?php namespace Tectonic\Shift\Modules\Localisation\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;

/**
 * Class Localisation
 *
 * @ORM\Entity
 * @ORM\Table(name="`localisations`")
 */
class Localisation extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="`id`")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="integer", name="`locale_id`") **/
    protected $localeId;

    /** @ORM\Column(type="integer", name="`foreign_id`") **/
    protected $foreignId;

    /** @ORM\Column(type="string", name="`resource`") **/
    protected $resource;

    /** @ORM\Column(type="string", name="`field`") **/
    protected $field;

    /** @ORM\Column(type="string", name="`value`") **/
    protected $value;

}