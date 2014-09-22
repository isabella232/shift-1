<?php

View::composers([
	'Tectonic\Shift\Library\Composers\LayoutsApplicationComposer' => ['shift::layouts.application'],
	'Tectonic\Shift\Library\Composers\AssetsComposer' => ['shift::layouts.application'],
]);

