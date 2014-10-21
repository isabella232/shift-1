<?php
namespace Tests\Acceptance\Modules\Configuration\Repositories;

use App;
use Tectonic\Shift\Modules\Configuration\Repositories\EloquentSettingRepository;
use Tests\AcceptanceTestCase;

class EloquentSettingRepositoryTest extends AcceptanceTestCase
{
    private $settingRepository;

    public function setUp()
    {
        parent::setUp();

        $this->settingRepository = App::make(EloquentSettingRepository::class);
    }

	public function testGetBySetting()
    {
        $setting = $this->settingRepository->getNew(['key' => 'setting', 'value' => 'value']);

        $this->settingRepository->save($setting);

        $savedSetting = $this->settingRepository->getByKey('setting');

        $this->assertEquals($setting->getValue(), $savedSetting);
    }
}
