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
}
