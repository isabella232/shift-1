<?php
namespace Tests\Acceptance\Modules\Configuration\Services;

use App;
use Mockery as m;
use Tests\AcceptanceTestCase;
use Tectonic\Shift\Modules\Configuration\Models\Setting;
use Tectonic\Shift\Modules\Configuration\Services\SettingsService;

class SettingsServiceTest extends AcceptanceTestCase
{
    protected $service;

    public function init()
    {
        $this->service = App::make(SettingsService::class);
    }

    public function testGetSettings()
    {
        // Arrange
        $this->generateSettings();

        // Act
        $settings = $this->service->getSettings();

        // Assert
        $expected = ['app.setting.one' => '1', 'app.setting.two' => '2', 'app.setting.three' => '3'];

        $this->assertSame($expected, $settings);
    }

    private function generateSettings()
    {
        $settings = [
            ['account_id' => 1, 'key' => 'app.setting.one', 'value' => '1'],
            ['account_id' => 1, 'key' => 'app.setting.two', 'value' => '2'],
            ['account_id' => 1, 'key' => 'app.setting.three', 'value' => '3'],
        ];

        foreach($settings as $setting) {
            Setting::create($setting);
        }
    }
}