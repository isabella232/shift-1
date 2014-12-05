<?php
namespace Tectonic\Shift\Library\Html;

use Tectonic\Shift\Library\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    protected $aliases = [
        'Button' => 'Tectonic\Shift\Library\Facades\Button'
    ];

	public function register()
    {
        parent::register();

        $this->registerButton();
    }

    public function registerButton()
    {
        $this->app->singleton('button', ButtonBuilder::class);
    }
}
