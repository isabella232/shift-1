<?php
use Tectonic\Shift\Library\Composers\AssetsComposer;
use Tectonic\Shift\Library\Composers\LocaleComposer;
use Tectonic\Shift\Library\Composers\LayoutsInstallationComposer;

View::composers([
    AssetsComposer::class => ['shift::layouts.fullpage'],
    LocaleComposer::class => ['shift::layouts.fullpage', 'shift::layouts.pjax'],
    LayoutsInstallationComposer::class => ['shift::layouts.installation'],
]);
