<?php
/**
 * Wraps up a number of random-use methods, including event name generation, some basic
 * data transformation/morphing and other methods.
 *
 * @author Kirk Bushell
 * @date   14th September 2013
 */
namespace Tectonic\Shift\Library;

use Exception;
use Illuminate\Http\Request;
use Illuminate\View\Environment as View;

class Utility
{
	/**
	 * Stores the request object for checks.
	 *
	 * @var Request
	 */
	protected $request;

	/**
	 * Stores the View object.
	 *
	 * @var View
	 */
	protected $view;

	public function __construct(Request $request, View $view)
	{
		$this->request = $request;
		$this->view = $view;
	}

	/**
	 * Generates a name to be used when firing an event. This is to help standardise
	 * the naming of events into one cohesive string. Class names should follow this
	 * naming convention, in that, an event name with:
	 *
	 * - $domain = 'search'
	 * - $type = 'roles' and
	 * - $name = 'filters'
	 *
	 * Should result in a class that resides in:
	 *
	 *  /Events/Search/Roles/Filters.php
	 *
	 * Within the appropriate package.
	 * 
	 * @param  array $args Variable number of arguments that can be passed to create the
	 *   event string. The first should always be the domain, such as search, model, auth.etc.
	 * @return string
	 * @throws Exception
	 */
	public function eventName($args = [])
	{
		$numArgs  = func_num_args();

		if ($numArgs < 2) {
			$exceptionMessage  = 'Utility::eventName expects at least 2 parameters (only '.$numArgs;
			$exceptionMessage .= ' provided). The first parameter should be the domain of the event, ';
			$exceptionMessage .= 'with extra arguments being used to craft the details of the event name.';

			throw new Exception($exceptionMessage);
		}

		$args   = func_get_args();
		$domain = array_shift($args);
		$type   = array_shift($args);

		$eventNameParts = [$domain, '::', $type];

		// We can have more than 2 parts, in which case, we just start stringing them
		// together, simply by joining the final parts together, with decimal points as the glue.
		if ($numArgs > 2) {
			array_walk($args, function($value) use(&$eventNameParts) {
				$eventNameParts[] = '.';
				$eventNameParts[] = $value;
			});
		}

		return implode($eventNameParts);
	}

	/**
	 * Returns the shift default layout if no JSON is not required.
	 *
	 * @return mixed
	 */
	public function noJsonView()
	{
		if (!$this->request->wantsJson()) {
			return $this->view->make('shift::layouts.application');
		}
	}
}
