<?php
namespace Tectonic\Shift\Modules\Localisation\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\TranslationInterface;

class Translation extends Model implements TranslationInterface
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
    public function language()
    {
        return $this->belongsTo(Language::class);
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
     * @return LanguageInterface
     */
    public function getLanguage()
    {
        return $this->language;
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
     * @param LocaleInterface $language
     * @return void
     */
    public function setLanguage(LanguageInterface $language)
    {
        $this->languageId = $language->getId();
    }

    /**
     * Creates a new localisation instance.
     *
     * @param LocaleInterface $language
     * @param $resource
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function add(LanguageInterface $language, $resource, $field, $value)
    {
        $localisation = new self;
        $localisation->setLocale($language);
        $localisation->setResource($resource);
        $localisation->setField($field);
        $localisation->setValue($value);

        return $localisation;
    }
}
