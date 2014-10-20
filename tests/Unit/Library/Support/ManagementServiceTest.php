<?php namespace Tests\Unit\Library\Support;

use Mockery;
use Tests\UnitTestCase;
use Tests\Stubs\ManagementServiceStub;

class ManagementServiceTest extends UnitTestCase
{
    protected $mockCreateValidator;
    protected $mockUpdateValidator;
    protected $mockRepository;
    protected $managementService;

    public function setUp()
    {
        parent::setUp();

        $this->mockCreateValidator = Mockery::mock('MockValidator');
        $this->mockUpdateValidator = Mockery::mock('MockValidator');
        $this->mockRepository = Mockery::mock('MockRepository');

        $this->managementService = new ManagementServiceStub(
            $this->mockRepository,
            $this->mockCreateValidator,
            $this->mockUpdateValidator
        );
    }

    /**
     * Test create resource
     * @test
     */
    public function testCreate()
    {
        $data = [];
        $msg = 'new resource created';

        $this->mockCreateValidator->shouldReceive('setInput')->with($data)->once()->andReturn($this->mockCreateValidator);
        $this->mockCreateValidator->shouldReceive('validate')->once();

        $this->mockRepository->shouldReceive('getNew')->with($data)->once()->andReturn('new resource');
        $this->mockRepository->shouldReceive('save')->with('new resource')->once()->andReturn('saved resource');

        $this->assertEquals($this->managementService->create($data), 'new resource');
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
        $msg = 'found resource and updating';

        $this->mockUpdateValidator->shouldReceive('setInput')->once()->andReturn($this->mockUpdateValidator);
        $this->mockUpdateValidator->shouldReceive('validate')->once();

        $this->mockRepository->shouldReceive('requireById')->with($id)->andReturn($msg);
        $this->mockRepository->shouldReceive('update')->with($msg, $params)->andReturn($msg);

        $this->assertEquals($this->managementService->update($id, $params), 'found resource and updating');
    }

    /**
     * Test delete resource
     * @test
     */
    public function testDelete()
    {
        $id = 1;

        $this->mockRepository->shouldReceive('requireById')->with($id)->once()->andReturn('found resource');
        $this->mockRepository->shouldReceive('delete')->with('found resource')->once();

        $this->assertEquals($this->managementService->delete($id), 'found resource');
    }
}
