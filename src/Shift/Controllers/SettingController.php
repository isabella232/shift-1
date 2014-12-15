<?php
namespace Tectonic\Shift\Controllers;

use Illuminate\Support\Facades\Input;
use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Configuration\Models\Setting;
use Tectonic\Shift\Modules\Configuration\Services\SettingsService;

class SettingController extends Controller
{
    /**
     * @var \Tectonic\Shift\Modules\Configuration\Services\SettingsService
     */
    protected $settingsService;

    /**
     * @param \Tectonic\Shift\Modules\Configuration\Services\SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index()
    {
        // I'm thinking setting will be globally available at some point, so we might
        // not need to include them here?
        $settings = $this->settingsService->getSettings();

        $registry = $this->settingsService->getRegisteredSettings();

        return $this->respond('shift::setting.index', compact('settings', 'registry'));
    }

    public function update()
    {
        dd(Input::get());

    }
}