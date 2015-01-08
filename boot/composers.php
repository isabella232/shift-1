<?php
use Tectonic\Shift\Library\Composers\ApplicationComposer;
use Tectonic\Shift\Library\Composers\AssetsComposer;
use Tectonic\Shift\Library\Composers\LocaleComposer;
use Tectonic\Shift\Library\Composers\LayoutsInstallationComposer;
use Tectonic\Shift\Library\Composers\MainMenuComposer;

View::composers([
    ApplicationComposer::class => ['shift::layouts.fullpage'],
    AssetsComposer::class => ['shift::layouts.fullpage'],
    LocaleComposer::class => ['shift::layouts.fullpage', 'shift::layouts.pjax'],
    LayoutsInstallationComposer::class => ['shift::layouts.installation'],
    MainMenuComposer::class => ['shift::layouts.fullpage'],
]);
