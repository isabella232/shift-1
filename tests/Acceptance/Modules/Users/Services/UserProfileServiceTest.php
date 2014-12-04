<?php
namespace Tests\Acceptance\Modules\Users\Services;

use Tests\AcceptanceTestCase;
use Illuminate\Support\Facades\App;
use Tectonic\Shift\Modules\Identity\Users\Services\UserProfileService;

class UserProfileServiceTest extends AcceptanceTestCase
{
    protected $service;

    public function init()
    {
        $this->service = App::make(UserProfileService::class);
    }

    public function testOnValidationFailure(){}

    public function testOnSuccess(){}
}