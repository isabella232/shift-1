<?php
namespace Tectonic\Shift\Modules\Identity\Users\Search\Filters;

use Tectonic\Shift\Library\Search\Filters\SearchFilterInterface;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;

class UserAccountFilter implements SearchFilterInterface
{
    /**
     * @var array
     */
    private $input;

    /**
     * @param array $input
     */
    function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * Apply the given search filter to an Eloquent query.
     *
     * @param $query
     * @return Query
     */
    public function applyToEloquent($query)
    {
        if (!array_get($this->input, 'relax')) {
            $accountId = CurrentAccount::get()->id;

            $query->join('account_user', 'account_user.user_id', '=', 'users.id');
            $query->where('account_user.account_id', '=', $accountId);
        }

        return $query;
    }
}
