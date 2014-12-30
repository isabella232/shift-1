<?php
namespace Tests\Unit\Library\Composers;

use Illuminate\Support\Facades\App;
use Tectonic\Shift\Library\Composers\LocaleComposer;
use Tectonic\Shift\Library\Facades\CurrentLocale;
use Tests\UnitTestCase;

class LocaleComposerTest extends UnitTestCase
{
	public function testLocaleSetup()
    {
        CurrentLocale::shouldReceive('code')->once()->andReturn('code');
        App::shouldReceive('setLocale')->with('code')->once();

        with(new LocaleComposer)->compose();
    }
}
