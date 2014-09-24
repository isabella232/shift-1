<?php namespace Tests\Acceptance\Modules\Localisation\Services;

use App;
use Tests\AcceptanceTestCase;
use Tectonic\Shift\Modules\Localisation\Services\Localiser;
use Tectonic\Shift\Modules\Localisation\Repositories\DoctrineLocaleRepository;
use Tectonic\Shift\Modules\Localisation\Repositories\DoctrineLocalisationRepository;

class DoctrineLocalisationRepositoryTest extends AcceptanceTestCase
{
    /**
     * @var Localiser
     */
    protected $localiser;

    /**
     * @var DoctrineLocaleRepository
     */
    protected $localeRepository;

    /**
     * @var DoctrineLocalisationRepository
     */
    protected $localisationRepository;

    /**
     * Data array complete with all required field to make a new locale or localisation
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

        $this->cleanData['locales'] = [
            ['locale'  => 'English (Great Britain)', 'code' => 'en_GB'],
            ['locale'  => 'English (Australian)', 'code'    => 'en_AU'],
            ['locale'  => 'English (New Zealand)', 'code'   => 'en_NZ'],
            ['locale'  => 'English (United States)', 'code' => 'en_US'],
        ];

        $this->cleanData['localisations'] = [
            ['localeId' => 1, 'foreignId' => 1, 'resource' => 'Tectonic\Shift\CustomField', 'field' => 'label', 'value' => 'Custom field en_GB'],
            ['localeId' => 2, 'foreignId' => 1, 'resource' => 'Tectonic\Shift\CustomField', 'field' => 'label', 'value' => 'Custom field en_AU'],
            ['localeId' => 3, 'foreignId' => 1, 'resource' => 'Tectonic\Shift\CustomField', 'field' => 'label', 'value' => 'Custom field en_NZ'],
            ['localeId' => 4, 'foreignId' => 1, 'resource' => 'Tectonic\Shift\Modules\Localisation\Entities\Locale', 'field' => 'locale', 'value' => 'Changed locale name!'],
        ];

        $this->localeRepository = App::make(DoctrineLocaleRepository::class);
        $this->localisationRepository = App::make(DoctrineLocalisationRepository::class);
        $this->localiser = new Localiser(App::make(DoctrineLocalisationRepository::class));
    }

    public function testLocaliseResourceUpdatesResourceLabel()
    {
        $this->createLocales();
        $this->createLocalisations();

        $locale = $this->localeRepository->requireById(1);

        $result = $this->localiser->localise($locale, ['locale'], 'en_US');

        $this->assertEquals($this->cleanData['localisations'][3]['value'], $result->getLocale());
    }

    private function createLocales()
    {
        foreach($this->cleanData['locales'] as $locale)
        {
            $resource = $this->localeRepository->getNew($locale);
            $this->localeRepository->save($resource);
        }
    }

    private function createLocalisations()
    {
        foreach($this->cleanData['localisations'] as $localisation)
        {
            $resource = $this->localisationRepository->getNew($localisation);
            $this->localisationRepository->save($resource);
        }
    }


}
