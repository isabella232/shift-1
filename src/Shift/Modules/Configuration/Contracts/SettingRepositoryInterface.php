<?php
namespace Tectonic\Shift\Modules\Configuration\Contracts;

interface SettingRepositoryInterface
{
    /**
     * Retrieve a setting by its name.
     *
     * @param string $key
     * @return mixed
     */
    public function getByKey($key);

    /**
     * Returns all of the settings, but returns an array as a key => value result.
     *
     * @return array
     */
    public function getAllAsKeyValue();

    /**
     * @param array $input
     */
    public function saveSettings($input);
}
