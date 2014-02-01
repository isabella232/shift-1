<?php 

namespace Tectonic\Shift\Core\Composers;

class LayoutsApplicationComposer
{
	public function compose($view)
	{
		$view->with('settings', []);
	}
}
