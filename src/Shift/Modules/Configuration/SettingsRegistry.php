<?php
namespace Tectonic\Shift\Modules\Configuration;

class SettingsRegistry
{
    /**
     * A registry to store all settings by group
     *
     * @var array
     */
    protected $registry = [];

    /**
     * Register a new setting/settings
     *
     * @param string $group
     * @param array  $settings
     */
    public function register($group, $settings)
    {
        if(!array_key_exists($group, $this->registry)) $this->registry[$group] = [];

        $this->registry[$group] = array_merge($this->registry[$group], $settings);
    }

    /**
     * Return all registered settings
     *
     * @return array
     */
    public function collectSettings()
    {
        return $this->registry;
    }
}