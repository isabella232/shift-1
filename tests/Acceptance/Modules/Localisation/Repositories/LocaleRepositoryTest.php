<?php namespace Tests\Acceptance\Modules\Localisation\Repositories;

use Mockery;
use Tests\TestCase;
use Tectonic\Shift\Modules\Localisation\Models\Locale;
use Tectonic\Shift\Modules\Localisation\Repositories\SqlLocaleRepository;

class LocaleRepositoryTest extends TestCase
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

        $this->repository = new SqlLocaleRepository(new Locale());
    }

    public function testGetCodeByIdReturnsCorrectCode()
    {
        $locale = $this->repository->getNew(['locale' => 'English (Great Britain)', 'code' => 'en_GB']);
        $locale->save();

        $this->assertSame($locale->code, $this->repository->getCode($locale->id));
    }

    public function testGetIdByCodeReturnsCorrectId()
    {
        $locale = $this->repository->getNew(['locale' => 'English (United States)', 'code' => 'en_US']);
        $locale->save();

        $this->assertSame($locale->id, (int) $this->repository->getId($locale->code));
    }

    public function testGetLocaleIdsReturnsArrayOfIds()
    {
        // Arrange
        foreach($this->cleanData as $data)
        {
            $locale = $this->repository->getNew(['locale' => $data['locale'], 'code' => $data['code']]);
            $locale->save();
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
