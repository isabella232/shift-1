<?php namespace Tectonic\Shift\Modules\CustomFields\Entities;

use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Timestamps;

/**
 * Class CustomField
 *
 * @entity(repositoryClass="Tectonic\Shift\Modules\CustomFields\Repositories\DoctrineCustomFieldRepository")
 * @table(name="custom_fields")
 */
class CustomField
{
    use Timestamps;
    use SoftDeletes;

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /** @Column(type="string" options={"default":"custom"}) **/
    private $group;

    /** @Column(type="string") **/
    private $resource;

    /** @Column(type="string") **/
    private $type;

    /** @Column(type="string" name="field_title") **/
    private $fieldTitle;

    /** @Column(type="string" name="field_code") **/
    private $fieldCode;

    /** @Column(type="string") **/
    private $label;

    /** @Column(type="text") **/
    private $options;

    /** @Column(type="text") **/
    private $validation;

    /** @Column(type="text") **/
    private $settings;

    /** @Column(type="boolean" options={"default":0}) **/
    private $required;

    /** @Column(type="boolean") **/
    private $registration;

    /** @Column(type="integer") **/
    private $order;


}