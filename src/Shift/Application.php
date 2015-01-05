<?php
namespace Tectonic\Shift;

use Illuminate\Filesystem\Filesystem;
use Tectonic\Shift\Library\Support\ProviderRepository;

class Application extends \Illuminate\Foundation\Application
{
    /**
     * Overloads the base application method so as to provide a custom provider repository.
     *
     * @return ProviderRepository
     */
    public function getProviderRepository()
    {
        $manifest = $this['config']['app.manifest'];

        return new ProviderRepository(new Filesystem, $manifest);
    }
}
