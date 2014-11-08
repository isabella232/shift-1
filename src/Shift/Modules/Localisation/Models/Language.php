<?php
namespace Tectonic\Shift\Modules\Localisation\Models;

use Tectonic\LaravelLocalisation\Database\Translation;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Accounts\Models\SupportedLanguage;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageInterface;

class Language extends Model implements LanguageInterface
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['language', 'code'];

    /**
     * A language has many localisations.
     *
     * @return mixed
     */
    public function translations()
    {
        return $this->hasMany(Translation::class, 'language', 'code');
    }

    /**
     * @return QueryBuilder
     */
    public function accounts()
    {
        return $this->hasManyThrough(SupportedLanguage::class);
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
    public function getLanguage()
    {
        return $this->language;
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
     * @param string $language
     * @return void
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Creates a new Locale instance.
     *
     * @param string $language
     * @param string $code
     * @return Language
     */
    public static function add($language, $code)
    {
        $resource = new self;
        $resource->setLanguage($language);
        $resource->setCode($code);

        return $resource;
    }
}
