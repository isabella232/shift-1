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
            'locales'  => 'English (Great Britain',
            'code'     => 'en_GB',
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

}
