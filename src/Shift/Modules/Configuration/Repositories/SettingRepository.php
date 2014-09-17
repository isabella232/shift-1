<?php namespace Tectonic\Shift\Modules\Configuration\Repositories;


class SettingRepository extends SqlBaseRepository implements SettingRepositoryInterface
{
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Retrieves a system setting by the setting name and returns its value. This method also provides a caching
     * mechanism, in that if a setting has previously been retrieved, it can be called for again and it will not
     * hit the database a second time.
     *
     * @param $setting
     * @return mixed
     */
    public function getBySetting($setting)
    {
        static $cache = [];

        if (isset($cache[$setting])) {
            return $cache[$setting];
        }

        $setting = $this->setting->whereSetting($setting)->first();

        if (!$setting) {
            throw with(new ModelNotFoundException)->setModel(get_class($this->setting));
        }

        $cache[$setting] = $setting->value;

        return $setting->value;
    }
}
