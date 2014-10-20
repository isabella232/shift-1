<?php

namespace Tests\Stubs;

use Tectonic\Shift\Library\Validation\Validation;

class ValidationStub extends Validation
{
    public function getRules()
    {
        return ['name' => 'required'];
    }
}
