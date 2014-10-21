<?php
namespace Tectonic\Shift\Modules\Fields;

use App;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Fields\Repositories\FieldRepositoryInterface;
use Tectonic\Shift\Modules\Fields\Repositories\DoctrineFieldRepository;

class FieldsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFieldRepository();
    }

    /**
     * Register CustomFields repository bindings
     */
    protected function registerFieldRepository()
    {
        $this->app->singleton(FieldRepositoryInterface::class, DoctrineFieldRepository::class);
    }
}