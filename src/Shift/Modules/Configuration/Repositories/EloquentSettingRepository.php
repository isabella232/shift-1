<?php
namespace Tectonic\Shift\Modules\Configuration\Repositories;

use Tectonic\Shift\Modules\Configuration\Contracts\SettingRepositoryInterface;
use Tectonic\Shift\Modules\Configuration\Models\Setting;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Library\Support\Database\RecordNotFoundException;

/**
 * Class SettingRepository
 *
 * @package Tectonic\Shift\Modules\Configuration\Repositories
 */
class EloquentSettingRepository extends Repository implements SettingRepositoryInterface
{
    private $settings = [];

    /**
     * @param Setting $setting
     */
    public function __construct(Setting $setting)
    {
        $this->model = $setting;
    }

    /**
     * Retrieves a system setting by the setting name and returns its value. This method also provides a caching
     * mechanism, in that if a setting has previously been retrieved, it can be called for again and it will not
     * hit the database a second time.
     *
     * @param string $key
     * @return mixed
     * @throws RecordNotFoundException
     */
    public function getByKey($key)
    {
        static $cache = [];

        if (isset($cache[$key])) {
            return $cache[$key];
        }

        $settings = $this->getAll();

        foreach ($settings as $setting) {
            if ($setting->getKey() == $key) {
                $cache[$key] = $setting->getValue();

                return $cache[$key];
            }
        }

        if (!$key) {
            throw with(new RecordNotFoundException('Setting', $key));
        }
    }

    /**
     * Retrieves all the settings available for the account, but returns the result as an associative array
     * of settingKey => settingValue.
     *
     * @return array
     */
    public function getAllAsKeyValue()
    {
        $settings = $this->getAll();
        $formatted = [];

        foreach ($settings as $s) {
            $formatted[$s->setting] = $s->value;
        }

        return $formatted;
    }
}
