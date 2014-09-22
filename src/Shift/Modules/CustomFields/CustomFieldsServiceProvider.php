<?php namespace Tectonic\Shift\Modules\CustomFields;

use App;
use Illuminate\Support\ServiceProvider;

class CustomFieldsServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCustomFieldsRepository();
    }

    /**
     * Register CustomFields repository bindings
     */
    protected function registerCustomFieldsRepository()
    {
        $this->app->bindShared('Tectonic\Shift\Modules\CustomFields\Repositories\CustomFieldRepositoryInterface', function()
        {
            return App::make('Tectonic\Shift\Modules\CustomFields\Repositories\CustomFieldRepository');
        });
    }
}