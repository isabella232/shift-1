<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Modules\Accounts\Entities\Account;
use Tectonic\Shift\Modules\Accounts\Entities\Domain;
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
     * @return array
	 */
	public function requireByDomain($domain)
    {
        $query = $this->entityManager()->createQuery()
            ->select(Account::class.' accounts')
            ->join('accounts.domains', Domain::class)
            ->where('domains.domain = \':domain\'')
            ->setParameter('domain', $domain);

        return $query->getSingleResult();
    }
}
