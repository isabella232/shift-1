<?php

namespace Tectonic\Shift\Library;

use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
	/**
	 * Stores the repository that will do most of the data-based heavy lifting.
	 *
	 * @var SqlBaseRepositoryInterface
	 */
	protected $repository;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->repository->search(Input::all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		return $this->repository->create(Input::get());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->repository->find($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		return $this->repository->update($id, Input::get());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->repository->delete($id);
	}
}
