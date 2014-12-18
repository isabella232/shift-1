<?php
namespace Tests\Unit\Library\Localisation;

use Illuminate\Support\Collection;
use Illuminate\Translation\FileLoader;
use Mockery as m;
use Tectonic\Localisation\Contracts\TranslationRepositoryInterface;
use Tectonic\Shift\Library\Localisation\TranslationLoader;
use Tests\UnitTestCase;

class TranslationLoaderTest extends UnitTestCase
{
    public function testLoading()
    {
        $mockFileLoader = m::mock(FileLoader::class);
        $mockRepository = m::mock(TranslationRepositoryInterface::class);

        $mockFileLoader->shouldReceive('load')->once()->with('locale', 'group', 'namespace')->andReturn(['value']);
        $mockRepository->shouldReceive('getByGroup')->once()->with('locale', 'ui', 'group')->andReturn(new Collection(['another']));

        $translationLoader = new TranslationLoader($mockFileLoader, $mockRepository);

        $this->assertEquals(['value', 'another'], $translationLoader->load('locale', 'group', 'namespace'));
    }

    public function testAddNamespace()
    {
        $mockFileLoader = m::spy(FileLoader::class);
        $mockRepository = m::spy(TranslationRepositoryInterface::class);

        $translationLoader = new TranslationLoader($mockFileLoader, $mockRepository);

        $translationLoader->addNamespace('shift', 'shift');

        $mockFileLoader->shouldHaveReceived('addNamespace')->once()->with('shift', 'shift');
    }
}
