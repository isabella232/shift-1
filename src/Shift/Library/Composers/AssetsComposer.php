<?php namespace Tectonic\Shift\Library\Composers;

use Asset;

class AssetsComposer
{
    public function compose()
    {
        $assetSuffix = App::environment() == 'production' ? 'min' : 'dev';

        // Add required assets to the asset container
        $container = Asset::container('shift');
        $container->add('app.js.shift' , "packages/tectonic/shift/js/shift.{$assetSuffix}.js");
        $container->add('app.css.shift' , "packages/tectonic/shift/css/shift.{$assetSuffix}.css");

        $customContainer = Asset::container('custom');
        $customContainer->add('app', 'js/app.js');
    }
}
