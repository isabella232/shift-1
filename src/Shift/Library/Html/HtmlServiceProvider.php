<?php
namespace Tectonic\Shift\Library\Html;

use Illuminate\Support\AggregateServiceProvider;
use Tectonic\Shift\Library\Providers\Providable;

class HtmlServiceProvider extends AggregateServiceProvider
{
    use Providable;

    /**
     * Only defer until the required Html classes are necessary.
     *
     * @var bool
     */
    public $defer = true;

    /**
     * @var array
     */
    protected $aliases = [
        'Button' => 'Tectonic\Shift\Library\Facades\Button',
        'Field' => 'Tectonic\Shift\Library\Facades\Field',
        'Form' => 'Illuminate\Html\FormFacade',
        'HTML' => 'Illuminate\Html\HtmlFacade',
        'Multilingual' => 'Tectonic\Shift\Library\Facades\Multilingual'
    ];

    /**
     * @var array
     */
    protected $providers = [
        'Illuminate\Html\HtmlServiceProvider'
    ];

    /**
     *
     */
    public function register()
    {
        parent::register();

        $this->app->singleton('button', ButtonBuilder::class);
        $this->app->singleton('field', FieldBuilder::class);
        $this->app->singleton('mlform', MultiLingualFormBuilder::class);

        $this->registerAliases();

        // Get our html macros setup
        require_once __DIR__.'/../../../../boot/macros.php';
    }

    /**
     * @return mixed
     */
    public function provides()
    {
        return aray_merge($this->providers, [
            'button',
            'Button',
            'field',
            'Field',
            'form',
            'Form',
            'html',
            'HTML',
            'mlform',
            'Multilingual'
        ]);
    }
}
