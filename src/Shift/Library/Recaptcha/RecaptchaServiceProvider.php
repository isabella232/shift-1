<?php
namespace Tectonic\Shift\Library\Recaptcha;

use Illuminate\Support\ServiceProvider;

class RecaptchaServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    public $defer = true;

    /**
     * Register the recaptcha instance.
     */
    public function register()
    {
        $this->app->singleton('recaptcha', function($app) {
            return new Recaptcha(new Curl, $app['config']->get('shift.recaptcha.keys.private'));
        });
    }

    /**
     * Return the instances/objects that Recaptcha provides.
     *
     * @return array
     */
    public function provides()
    {
        return ['recaptcha'];
    }
}
