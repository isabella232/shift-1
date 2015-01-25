<?php
namespace Tests\Unit\Library\Composers;

use Asset;
use Mockery as m;
use Tectonic\Shift\Library\Composers\AssetsComposer;

class AssetsComposerTest extends \Tests\UnitTestCase
{
	public function testSetsUpAssets()
    {
        $shiftAssetContainer = m::spy('assetContainer');

        Asset::shouldReceive('container')->once()->with('shift')->andReturn($shiftAssetContainer);

        $composer = new AssetsComposer;
        $composer->compose();

        $shiftAssetContainer->shouldHaveReceived('add')->twice();
    }
}
