<?php
namespace Tectonic\Shift\Library\Composers;

use App;
use Orchestra\Support\Facades\Asset;

class AssetsComposer
{
    public function compose()
    {
        $assetSuffix = App::environment('production') ? '.min' : '.dev';

        // Add required assets to the asset container
        $container = Asset::container('shift');
        $container->add('shift.js' , "packages/tectonic/shift/js/shift{$assetSuffix}.js");
        $container->add('shift.css' , "packages/tectonic/shift/css/shift{$assetSuffix}.css");

        // We can also have custom asset container that are bound to the view
        $customContainer = Asset::container('custom');
        $customContainer->add('app', 'packages/tectonic/shift/js/app.js');
    }
}
