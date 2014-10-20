<?php
namespace Tectonic\Shift\Library\Support\Database\Eloquent;

use Eloquence\Database\Traits\CamelCaseModel;

class Model extends \Eloquent
{
    // Ensure that fields are always approached with camel-casing
    use CamelCaseModel;
}
