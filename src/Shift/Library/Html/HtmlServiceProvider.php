<?php
namespace Tectonic\Shift\Library\Html;

use Tectonic\Shift\Library\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    protected $aliases = [
        'Button' => 'Tectonic\Shift\Library\Facades\Button',
        'Multilingual' => 'Tectonic\Shift\Library\Facades\Multilingual'
    ];

	public function register()
    {
        parent::register();

        $this->registerButton();
        $this->registerMultilingualForm();
    }

    public function registerButton()
    {
        $this->app->singleton('button', ButtonBuilder::class);
    }

    public function registerMultilingualForm()
    {
        $this->app->singleton('mlform', MultiLingualFormBuilder::class);
    }
}
