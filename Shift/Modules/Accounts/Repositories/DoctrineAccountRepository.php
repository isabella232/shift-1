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
        $qb = $this->entityManager()->createQueryBuilder()
            ->select('a')
            ->from(Account::class, 'a')
            ->join(Domain::class, 'd')
            ->where("d.domain = :domain")
            ->setParameter('domain', $domain);

	    $query = $qb->getQuery();

        return $query->getSingleResult();
    }
}
