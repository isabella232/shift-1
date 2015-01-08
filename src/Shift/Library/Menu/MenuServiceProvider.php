<?php
namespace Tectonic\Shift\Library\Menu;

use Tectonic\Shift\Library\Facades\Menufy;
use Tectonic\Shift\Library\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    protected $aliases = [
        'Menufy' => Menufy::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->app->singleton('menufy', Manager::class);
    }
}
