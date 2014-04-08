<?php

namespace Tectonic\Shift\Library\Theme;

use Illuminate\View\View as IlluminatedView

class View extends IlluminatedView
{
	/**
	 * Retrieves a requested view from the active theme.
	 *
	 * @return string
	 */
	public function view($view)
	{
		return $this->active()->view($view);
	}

	/**
	 * Templates are for the client-side. Very similar to the view method above. The requested view,
	 * should be provided as a relative path to the client folder of the active theme and skin. Eg.
	 *
	 *    $theme->template('users.index');
	 *
	 * @param string $template
	 */
	public function template($template)
	{
		$template = $this->active()->template($template);

		if (is_null($template)) {
			$this->app->abort(404);
		}

		return $output;
	}
}
