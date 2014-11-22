<?php
namespace Tests\Unit\Library\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Filters\ViewFilter;
use View;

class ViewFilterTest extends \Tests\UnitTestCase
{
	private $filter;
    private $mockRoute;
    private $mockRequest;
    private $mockResponse;

    public function init()
	{
		$this->mockRoute = m::mock('mockroute');
		$this->mockRequest = m::mock('mockrequest');
		$this->mockResponse = m::mock('mockresponse');

		$this->filter = new ViewFilter;
	}

	public function testFilterShouldReturnLayoutWhenNoOtherOptionsAreValid()
	{
		$this->mockRequest->shouldReceive('header')->once()->with('X-PJAX')->andReturn(false);
		$this->mockRequest->shouldReceive('wantsJson')->once()->andReturn(false);

        View::shouldReceive('make')->once();

		$this->filter->filter($this->mockRoute, $this->mockRequest, $this->mockResponse);
	}

    public function testFilterShouldReturnPartialViewDueToPjaxRequest()
    {
        $this->mockRequest->shouldReceive('header')->with('X-PJAX')->once()->andReturn(true);

        View::shouldReceive('make')->once();

        $this->filter->filter($this->mockRoute, $this->mockRequest, $this->mockResponse);
    }

    public function testFilterShouldReturnResponseForJsonRequests()
    {
        $this->mockRequest->shouldReceive('header')->once()->with('X-PJAX')->andReturn(false);
        $this->mockRequest->shouldReceive('wantsJson')->once()->andReturn(true);

        $filter = $this->filter->filter($this->mockRoute, $this->mockRequest, $this->mockResponse);

        $this->assertEquals($this->mockResponse, $filter);
    }
}
