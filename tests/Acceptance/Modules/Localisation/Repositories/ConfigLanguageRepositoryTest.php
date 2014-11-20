<?php
namespace Tests\Acceptance\Modules\Localisation\Repositories;

use App;
use Mockery;
use Tectonic\Shift\Modules\Localisation\Repositories\ConfigLanguageRepository;
use Tests\UnitTestCase;

class ConfigLanguageRepositoryTest extends UnitTestCase
{
    /**
     * @var SqlLocaleRepository
     */
    protected $repository;

    /**
     * Setup method to run before each test
     */
    public function init()
    {
        $this->repository = App::make(ConfigLanguageRepository::class);
    }

    public function testGetAll()
    {
        $this->assertCount(1, $this->repository->getAll());
    }

    public function testGetLanguage()
    {
        $language = $this->repository->getByCode('en_GB');

        $this->assertEquals('en_GB', $language->getCode());
        $this->assertEquals('English (Great Britain)', $language->getLanguage());
    }
}
