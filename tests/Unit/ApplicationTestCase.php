<?php
namespace Tests\Unit;

use Tectonic\Shift\Application;
use Tectonic\Shift\Library\Support\ProviderRepository;
use Tests\UnitTestCase;

class ApplicationTestCase extends UnitTestCase
{
	public function testProvideRepositoryInstantiation()
    {
        $app = new Application;
        $app['config'] = ['app.manifest' => ''];

        $this->assertInstanceOf(ProviderRepository::class, $app->getProviderRepository());
    }
}
