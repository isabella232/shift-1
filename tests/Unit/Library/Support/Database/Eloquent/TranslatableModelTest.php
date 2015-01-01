<?php
namespace Tests\Unit\Library\Support\Database\Eloquent;

use Tests\Stubs\TranslatableModelStub;
use Tests\UnitTestCase;

class TranslatableModelTest extends UnitTestCase
{
    /**
     * @expectedException \Exception
     */
	public function testAddingTranslationsForNewModelRecords()
    {
        $model = new TranslatableModelStub;
        $model->addTranslation('en', 'name', 'value');
    }
}
