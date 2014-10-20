<?php
namespace Tectonic\Shift\Modules\Startup;

use Event;
use Tectonic\Shift\Modules\Configuration\Repositories\SettingRepositoryInterface;

/**
 * Class StartupService
 *
 * Responsible for retrieving the relevant data necessary for bootstrapping the application on
 * the front-end. That means, retrieving language settings, current user, the current account and
 * domain records that are being accessed for the render, and more.
 *
 * @package Tectonic\Shift\Modules\Startup
 */
class StartupService
{
    /**
     * @var SettingRepositoryInterface
     */
    private $settingsRepository;

    /**
     * @param SettingRepositoryInterface $settingsRepository
     */
    public function __construct(SettingRepositoryInterface $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

	/**
	 * Application configuration required for bootstrap.
	 *
     * @fires Startup.Configuration.Started
	 * @return array
	 */
	public function configuration()
	{
        $configuration = [];
        $configuration['settings'] = $this->settingsRepository->getAllAsKeyValue();

        Event::fire('shift.configuration', [&$configuration]);

		return $configuration;
	}
}
