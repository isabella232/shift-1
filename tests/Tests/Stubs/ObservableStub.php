<?php

namespace Tests\Stubs;

use Tectonic\Shift\Library\Traits\Observable;

class ObservableStub
{
	use Observable;

	public static $observables = [
		'some.method',
		'another.event'
	];

	// Stub method, basically just making the fireEvent method public for testing
	public function fire()
	{
		$this->fireEvent('some.event');
	}
}
