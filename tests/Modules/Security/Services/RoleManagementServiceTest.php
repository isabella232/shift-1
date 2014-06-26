<?php

use Mockery as m;
use Tectonic\Shift\Modules\Security\Services\RoleManagementService;

class RoleManagementServiceTest extends Tests\TestCase
{
    private $service;

    public function setUp()
    {
        parent::setUp();

        $this->mockRepository  = m::mock('Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface');
        $this->mockValidator   = m::mock('Tectonic\Shift\Modules\Security\Validators\RoleValidator');

        $this->service  = new RoleManagementService($this->mockRepository, $this->mockValidator);
    }

    public function testCreate()
    {
        $this->mockRepository->shouldReceive('getNew')->with(['name' => 'roger'])->andReturn('new resource');
        $this->mockRepository->shouldReceive('save')->with('new resource')->andReturn('saved resource');

        $this->mockValidator->shouldReceive('setInput')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('forMethod')->with('create')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('validate')->once();

        $this->assertEquals($this->service->create(['name' => 'roger']), 'saved resource');
    }

    public function testGet()
    {
        $id = 1;
        $model = 'returned resource';

        $this->mockRepository->shouldReceive('requireById')->with($id)->andReturn($model);

        $this->assertEquals($this->service->get($id), $model);
    }

    public function testUpdate()
    {
        $params = ['param' => 'value'];
        $id = 1;

        $this->mockRepository->shouldReceive('requireById')->with($id)->andReturn('found resource');
        $this->mockRepository->shouldReceive('update')->with('found resource', $params)->andReturn('updated resource');

        $this->mockValidator->shouldReceive('setInput')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('forMethod')->with('update')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('using')->with('found resource')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('validate')->once();

        $this->assertEquals($this->service->update($id, $params), 'updated resource');
    }

    public function testDelete()
    {
        $this->mockRepository->shouldReceive('requireById')->with(1)->andReturn('found resource');
        $this->mockRepository->shouldReceive('delete')->with('found resource')->andReturn('deleted resource');

        $this->assertEquals($this->service->delete(1), 'deleted resource');
    }
}
