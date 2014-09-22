<?php
/**
 * Helpful HTML method for retrieving settings. This ensures we don't need to do checks
 * for each individual setting requests. This method will simply return null if it does
 * not exist.
 *
 * @param string $setting
 * @return mixed
 */
HTML::macro('setting', function($setting)
{
	/*$value = App::make('SettingsRepositoryInterface')->setting( $setting );

	if ( !empty( $value ) )
	{
		return $value;
	}*/

	return null;
});

/**
 * Retrieves the application configuration and settings necessary for booting. Some aspects,
 * such as the application user interface language settings, the current account, the logged-in
 * user and more, all need to be available as the application starts up.
 *
 * @return string Base64-encoded string of the configuration required for startup.
 */
HTML::macro('configuration', function() {
	$startupService = App::make('Tectonic\Shift\Modules\Startup\StartupService');
	$configuration = $startupService->configuration();
	$jsonPayload = json_encode($configuration);

	return base64_encode($jsonPayload);
});
