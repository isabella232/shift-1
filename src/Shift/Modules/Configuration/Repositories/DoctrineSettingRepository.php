<?php

namespace Tectonic\Shift\Modules\Configuration\Repositories;

use Tectonic\Shift\Modules\Configuration\Entities\Setting;
use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;
use Tectonic\Shift\Library\Support\Database\RecordNotFoundException;

/**
 * Class SettingRepository
 *
 * @package Tectonic\Shift\Modules\Configuration\Repositories
 */
class DoctrineSettingRepository extends Repository implements SettingRepositoryInterface
{
    protected $entity = Setting::class;

    /**
     * Is populated as soo nas getAll is called (acts as a cache).
     *
     * @var
     */
    private $settings;

    /**
     * Retrieves a system setting by the setting name and returns its value. This method also provides a caching
     * mechanism, in that if a setting has previously been retrieved, it can be called for again and it will not
     * hit the database a second time.
     *
     * @param $setting
     * @return mixed
     * @throws RecordNotFoundException
     */
    public function getBySetting($setting)
    {
        static $cache = [];

        if (isset($cache[$setting])) {
            return $cache[$setting];
        }

        $settings = $this->getAll();

        foreach ($settings as $s) {
            if ($s->setting == $setting) {
                $cache[$s->setting] = $s->value;

                return $s->value;
            }
        }

        if (!$setting) {
            throw with(new RecordNotFoundException('Setting', $setting));
        }
    }

    /**
     * Retrieves all database settings for the account.
     *
     * @return mixed
     */
    public function getAll()
    {
        if ($this->settings) return $this->settings;

        $queryBuilder = $this->createQuery();
        $query = $queryBuilder->getQuery();

        return $query->getResult();
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
