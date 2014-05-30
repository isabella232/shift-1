<?php namespace Tests\Unit\Modules\CustomFields\Repositories;

use Mockery;
use Tests\TestCase;
use Tectonic\Shift\Modules\CustomFields\Models\CustomField;
use Tectonic\Shift\Modules\CustomFields\Repositories\SqlCustomFieldRepository;

class CustomFieldRepositoryTest extends TestCase
{

    /**
     * @var Mockery
     */
    protected $mockModel;

    /**
     * Data array complete with all required field to make a new CustomField
     *
     * @var array
     */
    protected $cleanData;

    /**
     * Setup method to run before each test
     */
    public function setUp()
    {
        parent::setUp();

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

        $this->mockModel = Mockery::mock('Tectonic\Shift\Modules\CustomFields\Models\CustomField');
    }

    /**
     * Runs after every test
     */
    public function tearDown()
    {
        parent::tearDown();
        Mockery::close(); // Destroy any existing mocks before creating new ones
    }

    /**
     * Test repository calls the correct methods on CREATE operation.
     *
     * @test
     */
    public function testRepositoryPerformsCreateOperations()
    {
        // Arrange
        $this->mockModel->shouldReceive('newInstance')
            ->with($this->cleanData)
            ->once()
            ->andReturn($this->mockModel);
        $repository = new SqlCustomFieldRepository($this->mockModel);

        // Act
        $newModel = $repository->getNew($this->cleanData);

        // Assert
        $this->assertSame($this->mockModel, $newModel);
    }

    /**
     * Test repository can READ a record by id by calling correct methods.
     *
     * @test
     */
    public function testRepositoryPerformsReadOperations()
    {
        // Arrange
        $repository = new SqlCustomFieldRepository($this->mockModel);
        $this->mockModel
            ->shouldReceive('find')
            ->once()
            ->andReturn('resultingCustomField');

        // Act
        $result = $repository->getById(1);

        // Assert
        $this->assertEquals($result, 'resultingCustomField');
    }

    /**
     * Test repository performs UPDATE by calling correct methods.
     *
     * @test
     */
    public function testRepositoryPerformsUpdateOperation()
    {
        // Arrange
        $repository   = new SqlCustomFieldRepository($this->mockModel);
        $resourceMock = Mockery::mock('Tectonic\Shift\Modules\CustomFields\Models\CustomField');
        $data         = ['type' => 'aDifferentType'];

        // This test goes MENTAL if you say 'shouldReceive('touch') ???
        $resourceMock
            ->shouldReceive('fill')->with($data)->once()
            ->shouldReceive('getDirty')->once()
            ->shouldReceive('touch')->once()
            ->andReturn($resourceMock);

        // Act
        $result = $repository->update($resourceMock, $data);

        // Assert
        $this->assertSame($resourceMock, $result);
    }

    /**
     * Test repository performs DELETE by calling correct methods
     *
     * @test
     */
    public function testRepositoryPerformsDeleteOperation()
    {
        // Arrange
        $resourceOne = Mockery::mock('Tectonic\Shift\Modules\CustomFields\Models\CustomField');
        $repository  = new SqlCustomFieldRepository($this->mockModel);

        $resourceOne->shouldReceive('delete')->once()->andReturn($resourceOne);

        // Act
        $result = $repository->delete($resourceOne);

        // Assert
        $this->assertSame($resourceOne, $result);
    }
}
