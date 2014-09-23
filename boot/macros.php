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
	$value = App::make('Tectonic\Shift\Modules\Configuration\Repositories\SettingRepositoryInterface')->getBySetting($setting);

	if (!empty($value)) {
		return $value;
	}

	return null;
});

/**
 * Encodes a bootstrap configuration value as a json object and then
 *
 * @return string Base64-encoded string of the configuration required for startup.
 */
HTML::macro('obscure', function($configuration) {
	$jsonPayload = json_encode($configuration);

	return base64_encode($jsonPayload);
});
