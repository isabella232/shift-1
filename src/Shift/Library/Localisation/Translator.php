<?php
namespace Tectonic\Shift\Library\Localisation;

use Illuminate\Translation\Translator as IlluminateTranslator;
use Tectonic\Shift\Library\Translation\LoaderInterface;
use Tectonic\Shift\Library\Translation\UILocalisationService;
use Tectonic\Shift\Modules\Localisation\Services\TranslationsService;
use Tectonic\Shift\Modules\Localisation\Services\UITranslationService;

/**
 * Class Engine
 *
 * This class extends Laravel own translator class and adds a few extra helper
 * method for convenience. For example it can autoload module/package language
 * files and allow you to set/update key/value pairs with ease.
 *
 * An example of how the loaded array looks is as follows:
 *
 * $this->loaded = [
 *     'shift' => [                  // Module/package name
 *        'lang' => [                // File name (lang.php)
 *            'en_GB' => [           // Locale
 *                'ui' => [...]      // Key/value pairs
 *            ],
 *            'en_US' => [...],
 *        ],
 *    ]
 * ];
 *
 */
class Translator
{
    /**
     * UI Localisation Service
     *
     * @var UILocalisationService
     */
    protected $translationsService;

    /**
     * A list of supported locales.
     *
     * @var array
     */
    protected $supportedLocales;

    /**
     * @var IlluminateTranslator
     */
    private $translator;

    /**
     * Stores retrieved translation properties for subsequent calls.
     *
     * @var array
     */
    private $cache = [];

    /**
     * Construct class and autoload any specified package/module language files.
     *
     * @param LoaderInterface $loaderInterface
     * @param UILocalisationService $translationsService
     * @param string $locale
     * @param array $autoloads Modules/packages to autoload language files
     * @param array $locales
     */
    public function __construct(
        IlluminateTranslator $translator,
        TranslationsService $translationsService,
        array $locales = []
    )
    {
        $this->translator = $translator;
        $this->translationsService = $translationsService;
        $this->supportedLocales = $locales;
    }

    /**
     * Replacement to the get method on Illuminate's translator.
     *
     * @param string $key
     * @param array $replace
     * @param null $locale
     * @return string
     */
    public function get($key, array $replace = array(), $locale = null)
    {
        if (($cacheValue = array_get($this->cache, $key))) {
            return $cacheValue;
        }

        $default = $this->translator->get($key, $replace, $locale);

        // Look for customisations
        $value = $this->translationsService->get($key);

        array_set($this->cache, $key, $value);

        return $value;
    }

    /**
     * When dealing with particular areas, it's advantageous to prepare the cache based on the area you're in, before the
     * view is rendered and requires the various translated keys. This ensures minimal queries are made against the database for
     * a range of keys and values representing translations of required text.
     *
     * @param string|null $package
     * @param string $area
     */
    public function prepare($package, $area)
    {
        $namespace = !is_null($package) ? $package.'::' : '';
        $translations = $this->translator->get($namespace.$area);
        $dbTranslations = $this->translationsService->getByPartial('ui', $area);

        $this->hydrateFromLanguageFile($translations);
        $this->hydrateFromDatabase($dbTranslations);
    }

    /**
     * Set or update a key/value pair in the loaded array
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setKey($key, $value)
    {
        $exploded = explode('.', $key);

        $array = &$this->cache;

        foreach ($exploded as $key) {
            $array = &$array[$key];
        }

        $array = $value;

        unset($array);
    }

    /**
     * Set multiple key/value pair in the cache array
     *
     * @param array $keys
     * @return $this
     */
    public function setKeys(array $keys)
    {
        foreach ($keys as $key => $value) {
            $this->setKey($key, $value);
        }
    }

    /**
     * Hydrates the cache based on the array provided from a language translation file.
     *
     * @param array $translations
     */
    protected function hydrateFromLanguageFile(array $translations)
    {
        $this->cache = array_merge($this->cache, $translations);
    }

    /**
     * Hydrates the cache based on the translations provided by the database.
     *
     * @param array $dbTranslations
     */
    protected function hydrateFromDatabase(array $dbTranslations)
    {
        foreach ($dbTranslations as $translation) {
            $this->setKey($translation->field, $translation->value);
        }
    }

    /**
     * Any methods that do not exist should be piped through to the translator instance.
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->translator, $method], $args);
    }
}
