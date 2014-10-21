<?php namespace Tectonic\Shift\Modules\Localisation\Models;

use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Localisation\Contracts\LocaleInterface;

class Locale extends Model implements LocaleInterface
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['locale', 'code'];

    /**
     * A locale has many localisations.
     *
     * @return mixed
     */
    public function localisations()
    {
        return $this->hasMany(Localisation::class);
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $code
     * @return void
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param string $locale
     * @return void
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Creates a new Locale instance.
     *
     * @param string $locale
     * @param string $code
     * @return Locale
     */
    public static function add($locale, $code)
    {
        $resource = new self;
        $resource->setLocale($locale);
        $resource->setCode($code);

        return $resource;
    }
}
