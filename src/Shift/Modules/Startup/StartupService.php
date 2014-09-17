<?php

namespace Tectonic\Shift\Modules\Startup;

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
	 * Application configuration required for bootstrap.
	 *
	 * @return array
	 */
	public function configuration()
	{
		return [];
	}
}
