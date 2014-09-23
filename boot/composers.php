<?php

use Tectonic\Shift\Library\Composers\LayoutsApplicationComposer;
use Tectonic\Shift\Library\Composers\AssetsComposer;

View::composers([
    LayoutsApplicationComposer::class => ['shift::layouts.application'],
    AssetsComposer::class => ['shift::layouts.application'],
]);
