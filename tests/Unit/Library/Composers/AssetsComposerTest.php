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
        $customAssetContainer = m::spy('assetContainer');

        Asset::shouldReceive('container')->once()->with('shift')->andReturn($shiftAssetContainer);
        Asset::shouldReceive('container')->once()->with('custom')->andReturn($customAssetContainer);

        $composer = new AssetsComposer;
        $composer->compose();

        $shiftAssetContainer->shouldHaveReceived('add')->twice();
        $customAssetContainer->shouldHaveReceived('add')->once();
    }
}
