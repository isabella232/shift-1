<?php
namespace Tests\Unit\Modules\Authentication;

use Tectonic\Shift\Modules\Authentication\AccountSwitcherTokenGenerator;
use Tests\UnitTestCase;

class AccountSwitcherTokenGeneratorTest extends UnitTestCase
{
    public function testSettingData()
    {
        $generator = new AccountSwitcherTokenGenerator();

        $generator->setData(1, 2, 3);

        $expected = ['toAccount' => 1, 'fromAccount' => 2, 'userId' => 3];

        $this->assertSame($expected, $generator->data);
    }

    public function testGeneratingToken()
    {
        $generator = new AccountSwitcherTokenGenerator();

        $generator->setData(1, 2, 3);

        $this->assertSame(32, strlen($generator->generateToken()));
    }

    public function testEncodingData()
    {
        $generator = new AccountSwitcherTokenGenerator();

        $generator->setData(1, 2, 3);

        $expected = '{"toAccount":1,"fromAccount":2,"userId":3}';

        $this->assertSame($expected, $generator->encodeData());
    }

    public function testDecodingData()
    {
        $data = '{"toAccount":1,"fromAccount":2,"userId":3}';

        $generator = new AccountSwitcherTokenGenerator();

        $result = $generator->decodeData($data);

        $this->assertAttributeEquals(1, 'toAccount', $result);
        $this->assertAttributeEquals(2, 'fromAccount', $result);
        $this->assertAttributeEquals(3, 'userId', $result);
    }
}