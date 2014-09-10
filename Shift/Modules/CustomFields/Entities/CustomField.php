<?php namespace Tectonic\Shift\Modules\CustomFields\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;

/**
 * Class CustomField
 *
 * @ORM\Entity
 * @ORM\Table(name="custom_fields")
 * @ORM\HasLifecycleCallbacks()
 */
class CustomField extends Entity
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="string", options={"default": "custom"}) **/
    protected $group;

    /** @ORM\Column(type="string") **/
    protected $resource;

    /** @ORM\Column(type="string") **/
    protected $type;

    /** @ORM\Column(type="string", name="field_title") **/
    protected $fieldTitle;

    /** @ORM\Column(type="string", name="field_code") **/
    protected $fieldCode;

    /** @ORM\Column(type="string") **/
    protected $label;

    /** @ORM\Column(type="text") **/
    protected $options;

    /** @ORM\Column(type="text") **/
    protected $validation;

    /** @ORM\Column(type="text") **/
    protected $settings;

    /** @ORM\Column(type="boolean", options={"default":0}) **/
    protected $required;

    /** @ORM\Column(type="boolean") **/
    protected $registration;

    /** @ORM\Column(type="integer") **/
    protected $order;

}