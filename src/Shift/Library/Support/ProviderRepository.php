<?php
namespace Tectonic\Shift\Library\Support;

use Illuminate\Support\Facades\App;
use Tectonic\Shift\Application;

class ProviderRepository extends \Illuminate\Foundation\ProviderRepository
{
    /**
     * Because manifest caching is now handled by the shift:compile-deferred command,
     * we never want Laravel to manage this for us. As a result, force that recompiling
     * never occurs.
     *
     * @param array $manifest
     * @param array $providers
     * @return bool
     */
    public function shouldRecompile($manifest, $providers)
    {
        if (empty($manifest) or count($manifest) == 1) {
            return true;
        }

        return false;
    }

    /**
     * It's entirely possible with this approach that the manifest is empty. As a result,
     * we should return the default array if no manifest is found.
     *
     * @return array
     */
    public function loadManifest()
    {
        $manifest = parent::loadManifest();

        if (!$manifest) {
            $manifest = $this->default;
        }

        return $manifest;
    }

    /**
     * Compiles the manifest with the providers given.
     *
     * @param $manifest
     * @param $providers
     * @return array
     */
    public function compile(Application $app, $providers)
    {
        return $this->compileManifest($app, $providers);
    }

    /**
     * Make sure that the when element is part of the generated manifest array.
     *
     * @param array $providers
     * @return array
     */
    protected function freshManifest(array $providers)
    {
        return array_merge($this->default, parent::freshManifest($providers));
    }
}
