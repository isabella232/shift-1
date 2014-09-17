<?php namespace Tectonic\Shift\Modules\CustomFields\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;
use Tectonic\Shift\Library\Traits\Slugs;

/**
 * Class CustomField
 *
 * @ORM\Entity
 * @ORM\Table(name="`custom_fields`")
 * @ORM\HasLifecycleCallbacks()
 */
class CustomField extends Entity
{
    use Timestamps;
    use Slugs;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="`id`")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="string", options={"default": "custom"}, name="`group`") **/
    protected $group;

    /** @ORM\Column(type="string", name="`resource`") **/
    protected $resource;

    /** @ORM\Column(type="string", name="`type`") **/
    protected $type;

    /** @ORM\Column(type="string", name="`field_title`") **/
    protected $fieldTitle;

    /** @ORM\Column(type="string", name="`field_code`") **/
    protected $fieldCode;

    /** @ORM\Column(type="string", name="`label`") **/
    protected $label;

    /** @ORM\Column(type="text", name="`options`") **/
    protected $options;

    /** @ORM\Column(type="text", name="`validation`") **/
    protected $validation;

    /** @ORM\Column(type="text", name="`settings`") **/
    protected $settings;

    /** @ORM\Column(type="boolean", options={"default": "0"}, name="`required`") **/
    protected $required;

    /** @ORM\Column(type="boolean", options={"default": "0"}, name="`registration`") **/
    protected $registration;

    /** @ORM\Column(type="integer", name="`order`") **/
    protected $order;

}