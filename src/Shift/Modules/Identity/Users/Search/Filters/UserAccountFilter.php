<?php
namespace Tectonic\Shift\Modules\Identity\Users\Search\Filters;

use Tectonic\Shift\Library\Search\Filters\SearchFilterInterface;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;

class UserAccountFilter implements SearchFilterInterface
{
    /**
     * Apply the given search filter to an Eloquent query.
     *
     * @param $query
     * @return Query
     */
    public function applyToEloquent($query)
    {
        $accountId = CurrentAccount::get()->id;

        $query->join('account_user', 'account_user.user_id', '=', 'users.id');
        $query->where('account_user.account_id', '=', $accountId);

        return $query;
    }
}
