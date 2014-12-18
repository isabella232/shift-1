<?php
namespace Tests\Unit\Modules\Localisation\Services;

use Mockery as m;
use Tectonic\Localisation\Contracts\TranslationRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Services\TranslationService;
use Tests\UnitTestCase;

class TranslationServiceTest extends UnitTestCase
{
    private $service;
    private $mockTranslationsRepository;

    public function init()
    {
        $this->mockTranslationsRepository = m::spy(TranslationRepositoryInterface::class);
        $this->service = new TranslationService($this->mockTranslationsRepository);
    }

    public function testGetTranslations()
    {
        $this->service->get('field', 'resource', 2);

        $this->mockTranslationsRepository->shouldHaveReceived('getByCriteria')->with(['field' => 'field', 'resource' => 'resource', 'foreignId' => 2]);
    }

    public function testParamBuildingWithNullForeignId()
    {
        $this->service->get('field', 'resource');

        $this->mockTranslationsRepository->shouldHaveReceived('getByCriteria')->with(['field' => 'field', 'resource' => 'resource']);
    }
}
