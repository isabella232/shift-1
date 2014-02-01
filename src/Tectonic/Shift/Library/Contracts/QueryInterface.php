<?php

namespace Tectonic\Shift\Library\Contracts;

/**
 * The query interface contract is used by the search implementation so that we're always dealing with the
 * same methods, regardless of the storage mechanism used. In some cases, we use Sql/Eloquent, in other times
 * we may use mongo, or redis, or maybe something like Sales Force. In all cases, we want to ensure that the
 * way we deal with these classes are identical.
 */

interface QueryInterface
{
	public function where();
}
