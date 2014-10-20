<?php

namespace Tectonic\Shift\Library\Theme;

class Manager
{
	/**
	 * Stores the themes registered with the system.
	 * 
	 * @var array Theme
	 */
	protected $themes = [];

	/**
	 * Stores the currently active theme.
	 *
	 * @var Theme
	 */
	protected $activeTheme;

	/**
	 * Register a new theme with the manager.
	 *
	 * @param Theme $theme
	 * @param boolean $activate
	 */
	public function register(Theme $theme, $activate = false)
	{
		$this->themes[$theme->name()] = $theme;

		if ($activate) {
			$this->activate($theme->name());
		}
	}

	/**
	 * Sets the active theme. If the theme requested does not exist, it will
	 * throw an exception. Will return the active theme on success.
	 *
	 * @param string $theme
	 * @return Theme
	 */
	public function activate($theme)
	{
		if (!isset($this->themes[$theme])) {
			throw new Exception('Theme '.$theme.' has not been registered with the theme manager.');
		}

		$this->activeTheme = $this->themes[$theme];

		return $this->activeTheme;
	}

	/**
	 * Deactivate a given theme. It will only do so if it is already active.
	 *
	 * @param string $theme
	 */
	public function deactivate($theme)
	{
		try {
			$theme = $this->active();

			if ($theme->name == $theme) {
				$this->active = null;
			}
		}
	}

	/**
	 * Returns the currently active theme. If no theme has been activated, it will throw
	 * an exception.
	 *
	 * @return Theme
	 */
	public function active()
	{
		if (is_null($this->activeTheme)) {
			throw new Exception('There is no active theme defined.');
		}

		return $this->activeTheme;
	}
}
