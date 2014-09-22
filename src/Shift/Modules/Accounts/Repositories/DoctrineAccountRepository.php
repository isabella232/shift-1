<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Modules\Accounts\AccountNotFoundException;
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
	 * Accounts are the top-level root domain of the entire system. Therefore, they are removed
	 * from the default account restriction for querying.
	 *
	 * @var bool
	 */
	protected $restrictByAccount = false;

	/**
	 * Require an account based on the domain that has been provided. If no account is found,
	 * an AccountNotFoundException is thrown.rsi
	 *
	 * @param $domain
     * @return array
	 * @throws AccountNotFoundException
	 */
	public function requireByDomain($domain)
    {
		$domains = $this->getByDomain($domain);

	    if (!$domains or count($domains) > 1) {
			throw new AccountNotFoundException("An account for domain [$domain] could not be found.");
	    }

	    return $domains[0];
    }

	/**
	 * Searches for an account based on the domain provided.
	 *
	 * @param $domain
	 * @return mixed
	 */
	public function getByDomain($domain)
	{
		$qb = $this->entityManager()->createQueryBuilder()
			->select('a')
			->from(Account::class, 'a')
			->join(Domain::class, 'd')
			->where("d.domain = :domain")
			->setParameter('domain', $domain);

		$query = $qb->getQuery();

		return $query->getResult();
	}
}
