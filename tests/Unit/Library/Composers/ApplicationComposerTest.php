<?php
namespace Tests\Unit\Library\Composers;

use Mockery as m;
use Tectonic\Shift\Library\Composers\ApplicationComposer;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;

class ApplicationComposerTest extends \Tests\UnitTestCase
{
    public function testCurrentAccountIsSet()
    {
        $view = m::mock(ViewStub::class)->makePartial();

        $composer = new ApplicationComposer();
        $composer->compose($view);

        $view->shouldHaveReceived('with')->once()->withArgs(['account', CurrentAccount::translated()]);
    }
}

class ViewStub
{
    public function with($name, $value) {}
}
