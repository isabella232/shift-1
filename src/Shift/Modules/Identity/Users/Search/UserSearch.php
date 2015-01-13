<?php
namespace Tectonic\Shift\Modules\Identity\Users\Search;

use Tectonic\Shift\Library\Search\SearchFilterCollection;
use Tectonic\Shift\Library\Search\SearchInterface;
use Tectonic\Shift\Modules\Accounts\Models\User;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Search\Filters\UserAccountFilter;

class UserSearch implements SearchInterface
{
	/**
	 * @var UserRepositoryInterface
	 */
	private $userRepository;

	public function __construct(UserRepositoryInterface $userRepository)
	{
		$this->userRepository = $userRepository;
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

		$orderFilter = OrderFilter::byInput($input);
		$orderFilter->setDefaultField('users.id');

		$filterCollection->add($orderFilter);

		// @TODO: Only apply this if the user cannot manage accounts (aka, not a tectician)
		$filterCollection->add(new UserAccountFilter);

		$roles = $this->userRepository->getByFilters($filterCollection);

		return $roles;
	}
}
