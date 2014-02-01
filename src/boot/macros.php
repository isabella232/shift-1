<?php
/**
 * Helpful HTML method for retrieving settings. This ensures we don't need to do checks
 * for each individual setting requests. This method will simply return null if it does
 * not exist.
 *
 * @param string $setting
 * @return mixed
 */
HTML::macro( 'setting', function( $setting )
{
	$value = App::make('SettingsRepositoryInterface')->setting( $setting ); 
	
	if ( !empty( $value ) )
	{
		return $value;
	}
	
	return null;
});
