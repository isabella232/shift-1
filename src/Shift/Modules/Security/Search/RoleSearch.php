<?php

namespace Tectonic\Shift\Modules\Security\Search;

use Tectonic\Shift\Library\Search\SearchFilterCollection;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;
use Tectonic\Shift\Library\Search\SearchInterface;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface;

class RoleSearch implements SearchInterface
{
	/**
	 * Stores the role repository to be used for the search execution.
	 *
	 * @var RoleRepositoryInterface
	 */
	private $roleRepository;

	/**
	 * Setup the class dependencies, in this case - just the repository.
	 *
	 * @param RoleRepositoryInterface $roleRepository
	 */
	public function __construct(RoleRepositoryInterface $roleRepository)
	{
		$this->roleRepository = $roleRepository;
	}

	/**
	 * Setup the required filters necessary for executing a role search request, based on the $input provided.
	 *
	 * @param $input
	 * @return mixed
	 */
	public function fromInput(array $input = [])
	{
		$filterCollection = new SearchFilterCollection;

		if (isset($input['keywords'])) {
			$filterCollection->add(KeywordFilter::fromKeywords($input['keywords']));
		}

		$filterCollection->add(OrderFilter::byInput($input));

		return $this->roleRepository->getByCriteria($filterCollection);
	}
}
