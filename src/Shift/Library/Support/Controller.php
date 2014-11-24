<?php
namespace Tectonic\Shift\Library\Support;

use App;
use Input;
use Request;
use Response;
use Tectonic\Shift\Library\BaseValidator;
use Tectonic\Shift\Library\SqlBaseRepositoryInterface;
use View;

abstract class Controller extends \Illuminate\Routing\Controller
{
	/**
	 * Stores the full path to the search class to be used for search. The default search
	 * class is derived from conventions. The search class itself should sit inside the Search
	 * directory within a module.
	 *
	 * @var string
	 */
	public $searchClass;

    /**
     * The CRUDService stored represents the basic or base functionality for a given resource.
     *
     * @var CRUDService
     */
    public $crudService;

    /**
     * Setup the layout that may be required for the view.
     */
    protected function setupLayout()
    {
        if (!Request::wantsJson() && !$this->isPjax()) {
            $this->layout = View::make('shift::layouts.application');
        }
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$search = $this->resolveSearchClass();
		$results = $search->fromInput(Input::get());

		return Response::json($results);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
        return $this->crudService->create(Input::get());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		return $this->crudService->get($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function putUpdate($id)
	{
        return $this->crudService->update($id, Input::get());
	}

	/**
	 * Remove the specified resource from storage. If no id is provided as part of the URL,
     * then it will look to the delete's payload, which should be an array of ids to remove.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deleteDestroy($id = null)
	{
        if ($id) {
            $ids = [$id];
        }
        else {
            $ids = Input::get();
        }

        foreach ($ids as $id) {
            $this->crudService->delete($id);
        }

        return Response::make(null, 200);
	}

	/**
	 * Returns the resolved search class.
	 *
	 * @return mixed
	 */
	protected function resolveSearchClass()
	{
		return App::make($this->resolveSearchClassName());
	}

	/**
	 * Returns the name of the search class to be used for search execution.
	 *
	 * @param string $searchClass
	 * @return string
	 */
	protected function resolveSearchClassName()
	{
		return $this->searchClass;
	}

    /**
     * Respond with the the $data array for JSON, a partial of the view for PJAX requests,
     * or the full layout render if it's a full page request.
     *
     * @param string $view
     * @param array $data
     */
    protected function respond($view, array $data = [])
    {
        if (Request::wantsJson()) {
            return $data;
        }

        if ($this->isPjax()) {
            return View::make($view, $data);
        }

        $this->layout->main = View::make($view, $data);
    }

    /**
     * Determines whether or not the request is a PJAX request.
     *
     * @return bool
     */
    protected function isPjax()
    {
        return Request::header('X-PJAX') === 'true';
    }
}
