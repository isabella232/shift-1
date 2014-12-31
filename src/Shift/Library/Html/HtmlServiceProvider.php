<?php
namespace Tectonic\Shift\Library\Html;

use Tectonic\Shift\Library\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Only defer until the required Html classes are necessary.
     *
     * @var bool
     */
    public $defer = true;

    protected $aliases = [
        'Button' => 'Tectonic\Shift\Library\Facades\Button',
        'Field'  => 'Tectonic\Shift\Library\Facades\Field',
        'Multilingual' => 'Tectonic\Shift\Library\Facades\Multilingual'
    ];

	public function register()
    {
        parent::register();

        $this->registerButton();
        $this->registerField();
        $this->registerMultilingualForm();
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

    public function provides()
    {
        return [
            'button',
            'Button',
            'field',
            'Field',
            'mlform',
            'Multilingual'
        ];
    }
}
