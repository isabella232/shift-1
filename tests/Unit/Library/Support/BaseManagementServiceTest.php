<?php namespace Tests\Unit\Library\Support;

use Mockery;
use Tests\TestCase;
use Tests\Stubs\BaseManagementServiceStub;

class BaseManagementServiceTest extends TestCase
{
    protected $mockValidator;

    protected $mockRepository;

    protected $managementService;

    public function setUp()
    {
        parent::setUp();

        $this->mockValidator = Mockery::mock('MockValidator');
        $this->mockRepository = Mockery::mock('MockRepository');
        $this->managementService = new BaseManagementServiceStub($this->mockRepository, $this->mockValidator);
    }

    /**
     * Test create resource
     * @test
     */
    public function testCreate()
    {
        $data = [];

        $this->mockValidator->shouldReceive('setInput')->with($data)->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('forMethod')->with('create')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('validate')->once();

        $this->mockRepository->shouldReceive('getNew')->with($data)->andReturn('new resource');
        $this->mockRepository->shouldReceive('save')->with('new resource')->andReturn('saved resource');

        $this->assertEquals($this->managementService->create($data), 'saved resource');
    }

    /**
     * Test get resource
     * @test
     */
    public function testGet()
    {
        $id = 1;
        $model = 'returned resource';

        $this->mockRepository->shouldReceive('requireById')->with($id)->andReturn($model);

        $this->assertEquals($this->managementService->get($id), $model);
    }

    /**
     * Test update resource
     * @test
     */
    public function testUpdate()
    {
        $id = 1;
        $params = [];

        $this->mockValidator->shouldReceive('setInput')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('forMethod')->with('update')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('using')->with('found resource')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('validate')->once();

        $this->mockRepository->shouldReceive('requireById')->with($id)->andReturn('found resource');
        $this->mockRepository->shouldReceive('update')->with('found resource', $params)->andReturn('updated resource');

        $this->assertEquals($this->managementService->update($id, $params), 'updated resource');
    }

    /**
     * Test delete resource
     * @test
     */
    public function testDelete()
    {
        $id = 1;
        $this->mockRepository->shouldReceive('requireById')->with($id)->andReturn('found resource');
        $this->mockRepository->shouldReceive('delete')->with('found resource')->andReturn('deleted resource');

        $this->assertEquals($this->managementService->delete($id), 'deleted resource');
    }
}
