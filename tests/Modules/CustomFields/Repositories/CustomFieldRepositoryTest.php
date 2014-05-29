<?php

use Tectonic\Shift\Modules\CustomFields\Models\CustomField;
use Tectonic\Shift\Modules\CustomFields\Repositories\SqlCustomFieldRepository;

class CustomFieldRepositoryTest extends Tests\TestCase
{

    /**
     * Data array complete with all required field to make a new CustomField
     *
     * @var array
     */
    protected $cleanData;

    public function __construct()
    {
        parent::__construct();

        $this->cleanData = [
            'resource'     => 'user',
            'type'         => 'text',
            'field_title'  => 'Custom field title 1',
            'field_code'   => 'CFT',
            'label'        => '',
            'options'      => '',
            'validation'   => '',
            'settings'     => '',
            'required'     => true,
            'registration' => true,
            'order'        => 1
        ];
    }

    /**
     * Test repository calls the correct methods on CREATE operation
     *
     * @test
     */
    public function testRepositoryPerformsCreateOperations()
    {
        // Arrange
        $model = Mockery::mock('Tectonic\Shift\Modules\CustomFields\Models\CustomField');
        $model->shouldReceive('newInstance')
            ->with($this->cleanData)
            ->once()
            ->andReturn($model);
        $repository = new SqlCustomFieldRepository($model);

        // Act
        $newModel   = $repository->getNew($this->cleanData);

        // Assert
        $this->assertSame($model, $newModel);
    }

    /**
     * Test repository can READ a record by id.
     *
     * @test
     */
    public function testRepositoryPerformsReadOperations()
    {
        // Arrange
        $customField = CustomField::create($this->cleanData);
        $repository  = new SqlCustomFieldRepository(new CustomField);

        // Act
        $result = $repository->getById($customField->id);

        // Assert
        $this->assertSame((int)$customField->id, (int)$result->id);
        $this->assertSame($customField->field_title, $result->field_title);
    }
}
