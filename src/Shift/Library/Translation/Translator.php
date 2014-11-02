<?php namespace Tectonic\Shift\Library\Translation;

use Illuminate\Translation\LoaderInterface;
use Illuminate\Translation\Translator as IlluminateTranslator;
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
class Translator extends IlluminateTranslator
{
    /**
     * UI Localisation Service
     *
     * @var UILocalisationService
     */
    protected $UILocalisationService;

    /**
     * A list of supported locales.
     *
     * @var array
     */
    protected $supportedLocales;

    /**
     * Construct class and autoload any specified package/module language files.
     *
     * @param LoaderInterface $loaderInterface
     * @param UILocalisationService $UILocalisationService
     * @param string $locale
     * @param array $autoloads Modules/packages to autoload language files
     * @param array $locales
     */
    public function __construct(
        LoaderInterface $loaderInterface,
        UITranslationService $UILocalisationService,
        $locale,
        array $autoloads = [],
        array $locales = []
    )
    {
        $this->UILocalisationService = $UILocalisationService;
        $this->supportedLocales = $locales;

        parent::__construct($loaderInterface, $locale);

        $this->autoload($autoloads, $this->supportedLocales);
    }

    /**
     * Autoload the language file (lang.php) from each module (bundle/package) namespace
     * into the cached loaded array.
     *
     * @param array $namespaces
     * @param array $locales
     */
    protected function autoload(array $namespaces, array $locales)
    {
        // Foreach namespace (e.g. shift, awardforce ...)
        foreach($namespaces as $namespace)
        {
            // If locales is an empty array, just pull in translations for the default locale (en_GB)
            if(empty($locales))
            {
                $this->get("{$namespace}::lang", [], null);
            }
            else
            {
                // If locales is NOT empty, loop through and pull in all locale translation files.
                // E.g. lang/en_GB/lang.php, lang/en_US/lang.php ... etc
                foreach($locales as $locale)
                {
                    $this->get("{$namespace}::lang", [], $locale);
                }
            }
        }
    }

    /**
     * Return a complete list/array of all loaded language translations
     *
     * @return array
     */
    public function all()
    {
        return $this->loaded;
    }

    /**
     * Return JSON encode string of loaded array
     *
     * @return string
     */
    public function allToJson()
    {
        return json_encode($this->loaded);
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

        $array = &$this->loaded;

        foreach($exploded as $key) {
            $array = &$array[$key];
        }

        $array = $value;

        unset($array);

        return $this;
    }

    /**
     * Alias for setKey. Sets/updates a key/value pair in the loaded array.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function updateKey($key, $value)
    {
        $this->setKey($key, $value);

        return $this;
    }

    /**
     * Set multiple key/value pair in the loaded array
     *
     * @param array $keys
     * @return $this
     */
    public function setKeys(array $keys)
    {
        foreach($keys as $key => $value)
        {
            $this->setKey($key, $value);
        }

        return $this;
    }

    /**
     * Get custom UI localisations from data store, and update the loaded
     * array, by over writing default values with custom localisation.
     *
     * @param  array $locales
     * @return $this
     */
    public function setUICustomisations($locales = [])
    {
        if(empty($locales)) $locales = $this->supportedLocales;
        $keys = $this->UILocalisationService->getUILocalisations($locales);
        $this->setKeys($keys);

        return $this;
    }
}
