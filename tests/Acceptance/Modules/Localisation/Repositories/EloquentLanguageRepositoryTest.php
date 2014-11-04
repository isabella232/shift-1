<?php
namespace Tests\Acceptance\Modules\Localisation\Repositories;

use App;
use Mockery;
use Tests\AcceptanceTestCase;
use Tectonic\Shift\Modules\Localisation\Repositories\EloquentLanguageRepository;

class EloquentLanguageRepositoryTest extends AcceptanceTestCase
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
            ['language'  => 'English (Great Britain)', 'code'     => 'en_GB'],
            ['language'  => 'English (Australian)', 'code'     => 'en_AU'],
            ['language'  => 'English (New Zealand)', 'code'     => 'en_NZ'],
            ['language'  => 'English (United States)', 'code'     => 'en_US'],
        ];

        $this->repository = App::make(EloquentLanguageRepository::class);
    }

    public function testGetCodeByIdReturnsCorrectCode()
    {
        $language = $this->repository->getNew(['language' => 'English (Great Britain)', 'code' => 'en_GB']);

	    $this->repository->save($language);

        $this->assertSame($language->code, $this->repository->getLanguageCode($language->id));
    }

    public function testGetIdByCodeReturnsCorrectId()
    {
        $language = $this->repository->getNew(['language' => 'English (United States)', 'code' => 'en_US']);

	    $this->repository->save($language);

        $this->assertSame($language->id, (int) $this->repository->getLanguageId($language->code));
    }

    public function testGetLocaleIdsReturnsArrayOfIds()
    {
        $ids = [];

        // Arrange
        foreach($this->cleanData as $data)
        {
            $language = $this->repository->getNew(['language' => $data['language'], 'code' => $data['code']]);

	        $ids[] = $this->repository->save($language);
        }

        // Act
        $languageCodes = ['en_GB', 'en_NZ', 'en_AU'];
        $result = $this->repository->getLanguageIds($languageCodes);

        // Assert
        $this->assertCount(3, $result);

        foreach ($ids as $id) {
            $this->assertContains($id, $result);
        }
    }


}
