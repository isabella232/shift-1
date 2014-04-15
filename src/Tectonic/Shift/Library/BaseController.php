<?php

namespace Tectonic\Shift\Library;

use App;
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
     * Stores the validator class that will be used for validating create and update requests.
     *
     * @var BaseValidator
     */
    protected $validator;

	/**
	 * Stores the full path to the search class to be used for search. The default search
	 * class is derived from conventions. The search class itself should sit inside the Search
	 * directory within a module.
	 *
	 * @var string
	 */
	public $searchClass;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$search = $this->resolveSearchClass();

		$search->setParams(Input::get());
        $search->execute();

		return $search->results();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
        $input = Input::get();

        $this->validator->setInput($input)
            ->forMethod('create')
            ->validate();

		$resource = $this->repository->create($input);

		return $this->repository->save($resource);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		return $this->repository->requireById($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function putUpdate($id)
	{
        $input = Input::get();

		$resource = $this->repository->requireById($id);

        $this->validator->setInput($input)
            ->forMethod('update')
            ->using($resource)
            ->validate();

		return $this->repository->update($resource, Input::get());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id = null)
	{
		$resource = $this->repository->requireById($id);

		return $this->repository->delete($resource);
	}

	/**
	 * Returns the resolved search class.
	 *
	 * @return mixed
	 */
	protected function resolveSearchClass()
	{
		$className = $this->resolveSearchClassName($this->searchClass);

		$searchClass = App::make($className);

		return $searchClass;
	}

	/**
	 * Returns the name of the search class to be used for search execution.
	 *
	 * @param string $searchClass
	 * @return string
	 */
	protected function resolveSearchClassName($searchClass = null)
	{
		if (!is_null($searchClass)) return $searchClass;

		$class = get_class($this);
		$class = str_replace('Tectonic\Shift\Modules\\', '', $class);

		$classParts = explode('\\', $class);
		$module     = array_shift($classParts);
		$baseClass  = str_replace('Controller', '', array_pop($classParts)).'Search';

		$searchClassName = implode('\\', ['Tectonic\Shift\Modules', $module, 'Search', $baseClass]);

		return $searchClassName;
	}
}
