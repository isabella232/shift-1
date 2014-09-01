<?php 

namespace Tectonic\Shift\Library\Composers;

class LayoutsApplicationComposer
{
	public function compose($view)
	{
		$view->with('settings', []);
	}
}
