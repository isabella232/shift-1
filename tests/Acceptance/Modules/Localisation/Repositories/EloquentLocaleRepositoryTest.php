<?php namespace Tests\Acceptance\Modules\Localisation\Repositories;

use App;
use Mockery;
use Tests\AcceptanceTestCase;
use Tectonic\Shift\Modules\Localisation\Repositories\EloquentLocaleRepository;

class EloquentLocaleRepositoryTest extends AcceptanceTestCase
{

    /**
     * @var SqlLocaleRepository
     */
    protected $repository;

    /**
     * Data array complete with all required field to make a new CustomField
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

        Mockery::close(); // Destroy any existing mocks before creating new ones

        $this->cleanData = [
            ['locale'  => 'English (Great Britain)', 'code'     => 'en_GB'],
            ['locale'  => 'English (Australian)', 'code'     => 'en_AU'],
            ['locale'  => 'English (New Zealand)', 'code'     => 'en_NZ'],
            ['locale'  => 'English (United States)', 'code'     => 'en_US'],
        ];

        $this->repository = App::make(EloquentLocaleRepository::class);
    }

    public function testGetCodeByIdReturnsCorrectCode()
    {
        $locale = $this->repository->getNew(['locale' => 'English (Great Britain)', 'code' => 'en_GB']);

	    $this->repository->save($locale);

        $this->assertSame($locale->code, $this->repository->getLocaleCode($locale->id));
    }

    public function testGetIdByCodeReturnsCorrectId()
    {
        $locale = $this->repository->getNew(['locale' => 'English (United States)', 'code' => 'en_US']);

	    $this->repository->save($locale);

        $this->assertSame($locale->id, (int) $this->repository->getLocaleId($locale->code));
    }

    public function testGetLocaleIdsReturnsArrayOfIds()
    {
        $ids = [];

        // Arrange
        foreach($this->cleanData as $data)
        {
            $locale = $this->repository->getNew(['locale' => $data['locale'], 'code' => $data['code']]);

	        $ids[] = $this->repository->save($locale);
        }

        // Act
        $localeCodes = ['en_GB', 'en_NZ', 'en_AU'];
        $result = $this->repository->getLocaleIds($localeCodes);

        // Assert
        $this->assertCount(3, $result);

        foreach ($ids as $id) {
            $this->assertContains($id, $result);
        }
    }


}
