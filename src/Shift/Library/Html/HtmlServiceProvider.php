<?php
namespace Tectonic\Shift\Library\Html;

use Tectonic\Shift\Library\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    protected $aliases = [
        'Button' => 'Tectonic\Shift\Library\Facades\Button',
        'Field'  => 'Tectonic\Shift\Library\Facades\Field',
        'Multilingual' => 'Tectonic\Shift\Library\Facades\Multilingual',
        'Form' => 'Tectonic\Shift\Library\Facades\Form',
    ];

	public function register()
    {
        parent::register();

        $this->registerButton();
        $this->registerField();
        $this->registerMultilingualForm();
        $this->registerNewForm();
    }

    public function registerButton()
    {
        $this->app->singleton('button', ButtonBuilder::class);
    }

    public function registerField()
    {
        $this->app->singleton('field', FieldBuilder::class);
    }

    public function registerMultilingualForm()
    {
        $this->app->singleton('mlform', MultiLingualFormBuilder::class);
    }
    public function registerNewForm()
    {
        $this->app->singleton('newform', Form::class);
    }
}
