<?php

namespace Tectonic\Shift\Modules\Configuration\Repositories;

interface SettingRepositoryInterface
{
    /**
     * Retrieve a setting by its name.
     *
     * @param $setting
     * @return mixed
     */
    public function getBySetting($setting);

    /**
     * Get all settings.
     *
     * @return collection
     */
    public function getAll();

    /**
     * Returns all of the settings, but returns an array as a key => value result.
     *
     * @return array
     */
    public function getAllAsKeyValue();
}
