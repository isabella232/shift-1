<?php
namespace Tectonic\Shift\Modules\Localisation\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Localisation\Contracts\LocaleInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\LocalisationInterface;

class Localisation extends Model implements LocalisationInterface
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['localeId', 'foreignId', 'resource', 'field', 'value'];

    /**
     * Belongs to a Locale implementation.
     *
     * @return query
     */
    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return integer
     */
    public function getForeignId()
    {
        return $this->foreignId;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return LocaleInterface
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $field
     * @return void
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @param string $resource
     * @return void
     */
    public function setResource($resource)
    {
        $this->resouirce = $resource;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @param LocaleInterface $locale
     * @return void
     */
    public function setLocale(LocaleInterface $locale)
    {
        $this->localeId = $locale->getId();
    }

    /**
     * Creates a new localisation instance.
     *
     * @param LocaleInterface $locale
     * @param $resource
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function add(LocaleInterface $locale, $resource, $field, $value)
    {
        $localisation = new self;
        $localisation->setLocale($locale);
        $localisation->setResource($resource);
        $localisation->setField($field);
        $localisation->setValue($value);

        return $localisation;
    }
}
