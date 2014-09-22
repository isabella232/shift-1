<?php

namespace Tectonic\Shift\Library\Theme;

use Manager;

/**
 * The Shift ViewFinder looks in different locations and bases the look based on those themes.
 * If none of the themes or skins are able to return a requested file, then it will finally look
 * in the default views location of Laravel.
 */

class ViewFinder implements ViewFinderInterface
{
	public function __construct(Manager $manager)
	{
		$this->themeManager = $manager;
	}

	public function find($name)
	{
		$theme = $this->themeManager->active();
		$locations = array_reverse($theme->locations());

		foreach ($locations as $location)
	}
}