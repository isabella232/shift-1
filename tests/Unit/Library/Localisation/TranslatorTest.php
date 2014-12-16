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
}
