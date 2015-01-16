<?php
namespace Tectonic\Shift\Commands;

use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider
{
    /**
     * Defer the loading of this service provider, as we only need it when running commands.
     *
     * @var bool
     */
    public $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {}

    /**
     * Setup the command bindings once the service provider has booted.
     */
    public function boot()
    {
        $this->app->bind('command.shift.install', InstallCommand::class);
        $this->commands('command.shift.install');

        $this->app->bind('command.shift.reset', ResetCommand::class);
        $this->commands('command.shift.reset');

        $this->app->bind('command.shift.migrate', MigrateCommand::class);
        $this->commands('command.shift.migrate');

        $this->app->bind('command.shift.sync', SyncCommand::class);
        $this->commands('command.shift.sync');
    }

    /**
     * Let laravel know what commands/bindings are available to the system.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.shift.install',
            'command.shift.reset',
            'command.shift.migrate',
            'command.shift.sync'
        ];
    }

}
