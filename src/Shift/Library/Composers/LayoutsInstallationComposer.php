<?php
namespace Tectonic\Shift\Library\Composers;

use App;
use Asset;

class LayoutsInstallationComposer
{
    public function compose()
    {
        $assetSuffix = App::environment() == 'production' ? 'min' : 'dev';

        // Add required assets to the asset container
        $container = Asset::container('shift');
        $container->add('app.js.shift' , "packages/tectonic/shift/js/shift.{$assetSuffix}.js");
        $container->add('app.css.shift' , "packages/tectonic/shift/css/shift.{$assetSuffix}.css");
    }
}
