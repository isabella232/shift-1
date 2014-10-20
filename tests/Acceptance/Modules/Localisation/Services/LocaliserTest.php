<?php namespace Tests\Acceptance\Modules\Localisation\Services;

use App;
use Mockery as m;
use Tectonic\Shift\Modules\Localisation\Services\Localiser;
use Tests\Acceptance\Modules\Localisation\LocalisationTestCase;
use Tectonic\Shift\Modules\Localisation\Repositories\EloquentLocalisationRepository;

use Tests\UnitTestCase;

class LocaliserTest extends UnitTestCase
{
    /**
     * @var Localiser
     */
    protected $localiser;

    private $mockRepository;

    /**
     * Setup method to run before each test
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockRepository = m::spy(EloquentLocalisationRepository::class);
        $this->localiser = new Localiser($this->mockRepository);
    }

    public function testLocaliseResourceUpdatesResourceLabel()
    {
        $model = new \stdClass;
        $model->id = 'yo';

        $this->localiser->localise($model, ['field1', 'field2'], 'en_US');

        $this->mockRepository->shouldHaveReceived('findTranslation')->twice();
    }

    public function testLocaliseCollectionUpdatesResourceLabels()
    {
        $collection = [
            (object) ['id' => 1, 'name' => 'Some resource', 'field' => 'a value'],
            (object) ['id' => 2, 'name' => 'Another resource', 'field' => 'something else']
        ];

        $this->localiser->localiseCollection($collection, ['name', 'field'], 'en_US');

        $this->mockRepository->shouldHaveReceived('findTranslation')->times(4);
    }
}
