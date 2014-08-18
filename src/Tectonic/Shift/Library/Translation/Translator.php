<?php namespace Tectonic\Shift\Library\Translation;

use Illuminate\Translation\LoaderInterface;
use Illuminate\Translation\Translator as IlluminteTranslator;

/**
 * Class Translator
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
 *                'labels' => [...]  // Key/value pairs
 *            ],
 *        ],
 *    ]
 * ];
 *
 */
class Translator extends IlluminteTranslator
{
    /**
     * Construct class and autoload any specifed package/module language files.
     *
     * @param LoaderInterface $loaderInterface
     * @param string $locale
     * @param array $autoloads Modules/packages to autoload language files
     */
    public function __construct(LoaderInterface $loaderInterface, $locale, array $autoloads = [])
    {
        parent::__construct($loaderInterface, $locale);

        $this->autoload($autoloads);
    }

    /**
     * Autoload the language file from each module namespace
     * into the cached loaded array.
     *
     * @param array $namespaces
     */
    protected function autoload(array $namespaces)
    {
        foreach($namespaces as $namespace)
        {
            $this->get($namespace . '::lang');
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
     * Set or update a key/value pair in the loaded array
     *
     * @param $key
     * @param $value
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
    }

    /**
     * Alias for setKey. Sets/updates a key/value pair in the loaded array.
     *
     * @param $key
     * @param $value
     */
    public function updateKey($key, $value)
    {
        $this->setKey($key, $value);
    }

    /**
     * Set multiple key/value pair in the loaded array
     *
     * @param array $keys
     */
    public function setKeys(array $keys)
    {
        foreach($keys as $key => $value)
        {
            $this->setKey($key, $value);
        }
    }
}
