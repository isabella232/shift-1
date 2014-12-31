<?php
namespace Tectonic\Shift\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Tectonic\Shift\ShiftServiceProvider;

class CompileServicesCommand extends Command
{
    /**
     * @var string
     */
    protected $name = 'shift:compile-services';

    /**
     * @var string
     */
    protected $description = 'Compiles all deferred services, including via service providers that are provided by Shift';

    /**
     * Laravel application container.
     *
     * @var Container
     */
    private $app;

    /**
     * Used for doing queries and managing the cache data of providers and their services.
     *
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        parent::__construct();

        $this->app = $app;
        $this->providerRepository = $app->getProviderRepository();
    }

    /**
     * Fire the command.
     */
    public function fire()
    {
        $providers = $this->getProviders();

        $this->providerRepository->compile($this->app, $providers);
    }

    /**
     * Return all providers that need to be written to the manifest in one way or another.
     *
     * @return array
     */
    protected function getProviders()
    {
        $config = $this->app['config']['app'];
        $baseProviders = $this->createProvider(ShiftServiceProvider::class)->serviceProviders();
        $shiftProviders = $this->getShiftProviders($baseProviders);

        return array_merge($config['providers'], $shiftProviders);
    }

    /**
     * Recursively looks through all providers provided by Shift (and subsequent providers) and merges this with
     * the existing provider set provided in the initial call to the method.
     *
     * @param $providers
     * @return array
     */
    protected function getShiftProviders($providers)
    {
        $allProviders = [];

        foreach ($providers as $provider) {
            $instance = $this->createProvider($provider);

            $allProviders[] = $provider;

            if (method_exists($instance, 'serviceProviders')) {
                $allProviders = array_merge($allProviders, $this->getShiftProviders($instance->serviceProviders()));
            }
        }

        return $allProviders;
    }

    /**
     * Creates a new provider instance.
     *
     * @param string $provider
     * @return ServiceProvider
     */
    private function createProvider($provider)
    {
        return $this->providerRepository->createProvider($this->app, $provider);
    }
}
