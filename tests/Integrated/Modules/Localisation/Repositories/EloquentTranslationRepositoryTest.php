<?php
namespace Tests\Integrated\Modules\Localisation\Repositories;

use App;
use Mockery;
use Tests\IntegratedTestCase;
use Tectonic\Shift\Modules\Localisation\Repositories\ConfigLanguageRepository;
use Tectonic\Shift\Modules\Localisation\Repositories\EloquentTranslationRepository;

class EloquentTranslationRepositoryTest extends IntegratedTestCase
{
    /**
     * @var DoctrineLocaleRepository
     */
    protected $languageRepository;

    /**
     * @var DoctrineLocalisationRepository
     */
    protected $translationRepository;

    /**
     * Data array complete with all required field to make a new language or localisation
     *
     * @var array
     */
    protected $cleanData;

    /**
     * Setup method to run before each test
     */
    public function init()
    {
        $this->cleanData = [
            ['language' => 'en_GB', 'foreignId' => 1, 'resource' => 'Tectonic\Shift\CustomField', 'field' => 'label', 'value' => 'Custom field en_GB']
        ];

        $this->languageRepository = App::make(ConfigLanguageRepository::class);
        $this->translationRepository = App::make(EloquentTranslationRepository::class);
    }

    public function testFindTranslationFetchesTranslation()
    {
        $this->createLanguages();

        $result = $this->translationRepository->findTranslation('en_GB', 'Tectonic\Shift\CustomField', 'label', 1);

        $this->assertEquals($this->cleanData[0]['value'], $result->value);
    }

    private function createLanguages()
    {
        $translation = $this->translationRepository->getNew($this->cleanData[0]);

        $this->translationRepository->save($translation);
    }
}
