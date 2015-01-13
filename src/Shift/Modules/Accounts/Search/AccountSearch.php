<?php
namespace Tectonic\Shift\Modules\Accounts\Search;

use Tectonic\Shift\Library\Search\Filters\IncludeFilter;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;
use Tectonic\Shift\Library\Search\SearchFilterCollection;
use Tectonic\Shift\Library\Search\SearchInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;

class AccountSearch implements SearchInterface
{
    /**
     * Stores the account repository to be used for the search execution.
     *
     * @var RoleRepositoryInterface
     */
    private $accountRepository;

    /**
     * Setup the class dependencies, in this case - just the repository.
     *
     * @param RoleRepositoryInterface $accountRepository
     */
    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * Setup the required filters necessary for executing a role search request, based on the $input provided.
     *
     * @param array $input
     * @return mixed
     */
    public function fromInput(array $input = [])
    {
        $filterCollection = new SearchFilterCollection;
        $filterCollection->add(new IncludeFilter('owner', 'domains'));

        if (isset($input['keywords'])) {
            $filterCollection->add(KeywordFilter::fromKeywords($input['keywords']));
        }

        $filterCollection->add(OrderFilter::byInput($input));

        $accounts = $this->accountRepository->getByFilters($filterCollection);

        return $accounts;
    }
}
