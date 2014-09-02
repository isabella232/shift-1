<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Modules\Accounts\Entities\Account;
use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;

class DoctrineAccountRepository extends Repository implements AccountRepositoryInterface
{
	/**
	 * Required entity setting.
	 *
	 * @var string
	 */
	protected $entity = Account::class;

	/**
	 * Require an account based on the domain that has been provided.
	 *
	 * @param $domain
	 */
	public function requireByDomain($domain)
    {
        return $this->entityManager()->findOneByDomain($domain);
    }
}
