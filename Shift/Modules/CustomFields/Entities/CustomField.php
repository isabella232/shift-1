<?php namespace Tectonic\Shift\Modules\CustomFields\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Mitch\LaravelDoctrine\Traits\Timestamps;

/**
 * Class CustomField
 *
 * @ORM\Entity
 * @ORM\Table(name="custom_fields")
 * @ORM\HasLifecycleCallbacks()
 */
class CustomField
{
    use Timestamps;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
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
    }

}