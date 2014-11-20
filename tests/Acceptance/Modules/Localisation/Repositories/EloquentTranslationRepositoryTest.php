<?php
namespace Tests\Acceptance\Modules\Localisation\Repositories;

use App;
use Mockery;
use Tests\AcceptanceTestCase;
use Tectonic\Shift\Modules\Localisation\Repositories\EloquentLanguageRepository;
use Tectonic\Shift\Modules\Localisation\Repositories\EloquentTranslationRepository;

class EloquentTranslationRepositoryTest extends AcceptanceTestCase
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
    public function setUp()
    {
        parent::setUp();

        $this->cleanData['languages'] = [
            ['language'  => 'English (Great Britain)', 'code' => 'en_GB'],
            ['language'  => 'English (Australian)',    'code' => 'en_AU'],
            ['language'  => 'English (New Zealand)',   'code' => 'en_NZ'],
            ['language'  => 'English (United States)', 'code' => 'en_US']
        ];

        $this->cleanData['translations'] = [
            ['language' => 'en_GB', 'foreign_id' => 1, 'resource' => 'Tectonic\Shift\CustomField', 'field' => 'label', 'value' => 'Custom field en_GB'],
            ['language' => 'en_AU', 'foreign_id' => 1, 'resource' => 'Tectonic\Shift\CustomField', 'field' => 'label', 'value' => 'Custom field en_AU'],
            ['language' => 'en_NZ', 'foreign_id' => 1, 'resource' => 'Tectonic\Shift\CustomField', 'field' => 'label', 'value' => 'Custom field en_NZ'],
            ['language' => 'en_US', 'foreign_id' => 1, 'resource' => 'Tectonic\Shift\CustomField', 'field' => 'label', 'value' => 'Custom field en_US']
        ];

        $this->languageRepository = App::make(EloquentLanguageRepository::class);
        $this->translationRepository = App::make(EloquentTranslationRepository::class);
    }

    public function testFindTranslationFetchesTranslation()
    {
        $this->createLanguages();

        $result = $this->translationRepository->findTranslation(1, 'Tectonic\Shift\CustomField', 'label', 'en_NZ');

        $this->assertEquals($this->cleanData['translations'][2]['value'], $result['value']);
    }

    private function createLanguages()
    {
        foreach($this->cleanData['languages'] as $key => $language) {
            $resource = $this->languageRepository->getNew($language);
            $this->languageRepository->save($resource);

            $localisation = $this->translationRepository->getNew($this->cleanData['translations'][$key]);
            $resource->translations()->save($localisation);
        }
    }
}
