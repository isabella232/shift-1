<?php namespace Tests\Acceptance\Modules\Localisation\Repositories;

use App;
use Mockery;
use Tests\TestCase;
use Tectonic\Shift\Modules\Localisation\Repositories\DoctrineLocaleRepository;

class DoctrineLocaleRepositoryTest extends TestCase
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

        $this->repository = App::make(DoctrineLocaleRepository::class);
    }

    public function testGetCodeByIdReturnsCorrectCode()
    {
        $locale = $this->repository->getNew(['locale' => 'English (Great Britain)', 'code' => 'en_GB']);

	    $this->repository->save($locale);

        $this->assertSame($locale->getCode(), $this->repository->getLocaleCode($locale->getId()));
    }

    public function testGetIdByCodeReturnsCorrectId()
    {
        $locale = $this->repository->getNew(['locale' => 'English (United States)', 'code' => 'en_US']);

	    $this->repository->save($locale);

        $this->assertSame($locale->getId(), (int) $this->repository->getLocaleId($locale->getCode()));
    }

    public function testGetLocaleIdsReturnsArrayOfIds()
    {
        // Arrange
        foreach($this->cleanData as $data)
        {
            $locale = $this->repository->getNew(['locale' => $data['locale'], 'code' => $data['code']]);

	        $this->repository->save($locale);
        }

        // Act
        $localeCodes = ['en_GB', 'en_NZ', 'en_AU'];
        $result = $this->repository->getLocaleIds($localeCodes);

        // Assert
        $this->assertCount(3, $result);
        $this->assertContains('1', $result);
        $this->assertContains('2', $result);
        $this->assertContains('3', $result);
        $this->assertNotContains('4', $result);
    }


}
