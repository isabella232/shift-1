<?php namespace Tectonic\Shift\Modules\Authentication\Contracts;

interface TokenRepositoryInterface
{
    /**
     * Get a record by token.
     *
     * @param string $token
     *
     * @return mixed
     */
    public function getByToken($token);
}