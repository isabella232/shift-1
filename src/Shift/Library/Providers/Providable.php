<?php
namespace Tectonic\Shift\Library\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;

trait Providable
{
    /**
     * If there are any listeners defined on the service provider, here we'll loop through
     * them and register them as subscribers with Laravel's events system.
     *
     * The format of the array on the service provider should be:
     *
     *     'some.event' => SomeEventListener::class
     */
    protected function registerListeners()
    {
        if (!isset($this->listeners)) return;

        foreach ($this->listeners as $event => $listener) {
            Event::listen($event, $listener);
        }
    }

    /**
     * Register aliases. Format of aliases array on the service provider should be:
     *
     *     'SomeClass' => 'Path\To\SomeClass'
     *
     * @returns void
     */
    protected function registerAliases()
    {
        if (!isset($this->aliases)) return;

        foreach ($this->aliases as $alias => $abstract) {
            AliasLoader::getInstance()->alias($alias, $abstract);
        }
    }

    /**
     * Registers the defined repository interfaces and binds them to an implementation.
     *
     * Format of the array should be:
     *
     *     'RepositoryInterface' => 'RepositoryImplementation'
     *
     * @return void
     */
    protected function registerRepositories()
    {
        if (!isset($this->repositories)) return;

        foreach ($this->repositories as $interface => $repository) {
            $this->app->singleton($interface, $repository);
        }
    }
}
