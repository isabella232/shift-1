<?php

namespace Tectonic\Shift\Library;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;

abstract class BaseController extends Controller
{
	/**
	 * Stores the repository that will do most of the data-based heavy lifting.
	 *
	 * @var SqlBaseRepositoryInterface
	 */
	protected $repository;

	/**
	 * Most controllers require a search mechanism. By setting the search value
	 * from the child's controller, this requirement is met.
	 *
	 * @var Search
	 */
	protected $search;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->search->setParams(Input::get());

		return $this->search->results();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$resource = $this->repository->create(Input::get());

		return $this->repository->save($resource);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->repository->requireById($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$resource = $this->repository->requireById($id);

		return $this->repository->update($resource, Input::get());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$resource = $this->repository->requireById($id);

		return $this->repository->delete($resource);
	}
}
