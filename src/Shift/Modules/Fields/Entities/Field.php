<?php namespace Tectonic\Shift\Modules\Fields\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;
use Tectonic\Shift\Modules\Accounts\Entities\Accountable;

/**
 * Class CustomField
 *
 * @ORM\Entity
 * @ORM\Table(name="`fields`")
 * @ORM\HasLifecycleCallbacks()
 */
class Field extends Entity
{
    use Accountable;
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="`id`")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(type="string", name="`resource`") **/
    protected $resource;

    /** @ORM\Column(type="string", name="`type`") **/
    protected $type;

    /** @ORM\Column(type="string", name="`field_code`") **/
    protected $code;

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

    /**
     * @param $resource
     * @param $type
     */
    public function __construct($resource, $type)
    {
        $this->resource = $resource;
        $this->type = $type;
    }
}