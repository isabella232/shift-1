<?php
namespace Tectonic\Shift\Library\Support;

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
        return false;
    }
}
