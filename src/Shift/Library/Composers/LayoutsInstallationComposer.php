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
        $container->add('app.js.shift' , "js/shift.{$assetSuffix}.js");
        $container->add('app.css.shift' , "css/shift.{$assetSuffix}.css");
    }
}
