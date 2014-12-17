<?php
namespace Tests\Unit\Modules\Configuration;

use Mockery as m;
use Tests\UnitTestCase;
use Tectonic\Shift\Modules\Configuration\SettingsRegistry;

class SettingsRegistryTest extends UnitTestCase
{
    public function testRegisteringNewSettings()
    {
        // Arrange
        $registry = new SettingsRegistry();

        // Act
        $registry->register('group_one', [['setting.one'], ['setting.two']]);

        // Assert
        $this->assertArrayHasKey('group_one', $registry->collectSettings());
        $this->assertCount(2, $registry->collectSettings()['group_one']);
    }

    public function testRegisteringSettingsToExistingGroupMergesThemBoth()
    {
        // Arrange
        $registry = new SettingsRegistry();
        $registry->register('group_one', [['setting.one'], ['setting.two']]);

        // Act
        $registry->register('group_one', [['setting.three'], ['setting.four']]);

        // Assert
        $this->assertCount(1, $registry->collectSettings());
        $this->assertCount(4, $registry->collectSettings()['group_one']);
    }

    public function testRegisteringNewSettingsIntoMultipleGroups()
    {
        // Arrange
        $registry = new SettingsRegistry();

        // Act
        $registry->register('group_one', [['setting.one'], ['setting.two']]);
        $registry->register('group_two', [['setting.three'], ['setting.four']]);
        $registry->register('group_three', [['setting.five'], ['setting.six']]);

        // Assert
        $this->assertCount(3, $registry->collectSettings());
    }

    public function testCollectSettingsReturnsAnArrayOfGroupedSettings()
    {
        // Arrange
        $registry = new SettingsRegistry();

        // Act
        $registry->register('group_one', [['setting.one'], ['setting.two']]);
        $registry->register('group_two', [['setting.three'], ['setting.four']]);

        // Assert
        $expected = ['group_one' => [['setting.one'], ['setting.two']], 'group_two' => [['setting.three'], ['setting.four']]];
        $this->assertSame($expected, $registry->collectSettings());
    }
}