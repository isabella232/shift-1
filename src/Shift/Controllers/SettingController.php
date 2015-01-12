<?php
namespace Tectonic\Shift\Controllers;

use Illuminate\Support\Facades\Redirect;
use Input;
use Tectonic\Shift\Library\Support\Controller;
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

    /**
     * Display editable settings.
     *
     * @Get("/settings", middleware="shift.account", prefix="/")
     *
     * @return array
     */
    public function index()
    {
        // I'm thinking settings will be globally available at some point, so we might
        // not need to include them here permanently.
        $settings = $this->settingsService->getSettings();

        $registry = $this->settingsService->getRegisteredSettings();

        return $this->respond('shift::setting.index', compact('settings', 'registry'));
    }

    /**
     * Update modified settings.
     *
     * @Post("/settings", middleware="shift.account", prefix="/")
     */
    public function update()
    {
        // TODO: Establish a method of validating settings?
        // ...

        $this->settingsService->update(Input::get());

        return Redirect::action('Tectonic\Shift\Controllers\SettingController@index');
    }
}