<?php

use Tectonic\Shift\Library\Composers\AssetsComposer;
use Tectonic\Shift\Library\Composers\LayoutsApplicationComposer;
use Tectonic\Shift\Library\Composers\LayoutsInstallationComposer;

View::composers([
    AssetsComposer::class => ['shift::layouts.fullpage'],
    LayoutsInstallationComposer::class => ['shift::layouts.installation'],
]);
