<?php namespace Tectonic\Shift\Modules\Authentication\Repositories;

use Tectonic\Shift\Modules\Authentication\Models\Token;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Authentication\Contracts\TokenRepositoryInterface;

class EloquentTokenRepository extends Repository implements TokenRepositoryInterface
{
    /**
     * @param \Tectonic\Shift\Modules\Authentication\Models\Token $model
     */
    public function __construct(Token $model)
    {
        $this->model = $model;
    }

    /**
     * Get a record by token.
     *
     * @param string $token
     *
     * @return mixed
     */
    public function getByToken($token)
    {
        return $this->getOneBy('token', $token);
    }
}