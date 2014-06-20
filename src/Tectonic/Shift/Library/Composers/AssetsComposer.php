<?php namespace Tectonic\Shift\Library\Composers;


use Tectonic\Shift\Library\Facades\Asset;

class AssetsComposer
{
    public function compose($view)
    {
        // Add required assets to the asset container
        $container = Asset::container('shift');
        $container->add('shift', 'packages/tectonic/shift/js/shift.js');

        $customContainer = Asset::container('custom');
        $customContainer->add('app', 'packages/tectonic/shift/js/app.js');
    }
}
