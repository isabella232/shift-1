<?php
namespace Tectonic\Shift\Modules\Configuration\Services;

use Illuminate\Support\Facades\Event;
use Tectonic\Shift\Modules\Configuration\SettingsRegistry;
use Tectonic\Shift\Modules\Configuration\Contracts\SettingRepositoryInterface;

class SettingsService
{
    /**
     * @var \Tectonic\Shift\Modules\Configuration\Contracts\SettingRepositoryInterface
     */
    protected $settingsRepository;

    /**
     * @param \Tectonic\Shift\Modules\Configuration\Contracts\SettingRepositoryInterface $settingsRepository
     */
    public function __construct(SettingRepositoryInterface $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function getSettings()
    {
        return $this->settingsRepository->getAllAsKeyValue();
    }

    public function getRegisteredSettings()
    {
        $registry = new SettingsRegistry();

        $registry->register('General', [
            ['name' => 'app.site.name', 'type' => 'text', 'label' => 'Site name'],
            ['name' => 'app.site.desc', 'type' => 'text', 'label' => 'Site desc']
        ]);

        Event::fire('register.settings', [$registry]);

        return $registry->collectSettings();
    }
}