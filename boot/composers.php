<?php
use Tectonic\Shift\Library\Composers\ApplicationComposer;
use Tectonic\Shift\Library\Composers\AssetsComposer;
use Tectonic\Shift\Library\Composers\LocaleComposer;
use Tectonic\Shift\Library\Composers\LayoutsInstallationComposer;

View::composers([
    AssetsComposer::class => ['shift::layouts.fullpage'],
    LocaleComposer::class => ['shift::layouts.fullpage'],
    LayoutsInstallationComposer::class => ['shift::layouts.installation'],
    ApplicationComposer::class => ['shift::layouts.fullpage'],
]);
