<?php
namespace Tests\Unit\Library\Localisation;

use Illuminate\Translation\Translator as IlluminateTranslator;
use Tectonic\Shift\Library\Localisation\Translator;
use Mockery as m;
use Tectonic\Shift\Modules\Localisation\Services\TranslationsService;
use Tests\UnitTestCase;

class TranslatorTest extends UnitTestCase
{
    private $mockIlluminateTranslator;
    private $mockTranslationsService;
    private $translator;

	public function init()
    {
        $this->mockIlluminateTranslator = m::mock(IlluminateTranslator::class);
        $this->mockTranslationsService = m::mock(TranslationsService::class);

        $this->translator = new Translator($this->mockIlluminateTranslator, $this->mockTranslationsService);
    }

    public function testTranslationPreparation()
    {
        $translation = new \stdClass;
        $translation->field = 'roles.title';
        $translation->value = 'My roles';

        $this->mockIlluminateTranslator->shouldReceive('get')->once()->with('shift::roles')->andReturn(['title' => 'roles']);
        $this->mockTranslationsService->shouldReceive('getByPartial')->once()->with('ui', 'roles')->andReturn([$translation]);

        $this->translator->prepare('shift', 'roles');

        $this->assertEquals('My roles', $this->translator->get('roles.title'));
    }

    public function testTranslationRetrieval()
    {
        $this->mockIlluminateTranslator->shouldReceive('get')->once()->with('some.field', [], null);
        $this->mockTranslationsService->shouldReceive('get')->once()->with('some.field', 'ui')->andReturn(null);

        $this->assertNull($this->translator->get('some.field'));
    }

    public function testTranslationRetrievalWithNoCustomisations()
    {
        $this->mockIlluminateTranslator->shouldReceive('get')->once()->with('some.field', [], null)->andReturn('a value');
        $this->mockTranslationsService->shouldReceive('get')->once()->with('some.field', 'ui')->andReturn(null);

        $this->assertEquals('a value', $this->translator->get('some.field'));
    }

    public function testTranslationRetrievalWithCustomisations()
    {
        $this->mockIlluminateTranslator->shouldReceive('get')->once()->with('another.field', [], null)->andReturn('a value');
        $this->mockTranslationsService->shouldReceive('get')->once()->with('another.field', 'ui')->andReturn('another value');

        $this->assertEquals('another value', $this->translator->get('another.field'));
    }

    public function testCacheKeySetting()
    {
        $this->translator->setKey('a.very.nested.translated.field', 'value');

        $this->assertEquals('value', $this->translator->get('a.very.nested.translated.field'));
    }

    public function testBulkCacheKeySetting()
    {
        $this->translator->setKeys(['a.key' => 'a value', 'another.key' => 'another value']);

        $this->assertEquals('a value', $this->translator->get('a.key'));
        $this->assertEquals('another value', $this->translator->get('another.key'));
    }
}
