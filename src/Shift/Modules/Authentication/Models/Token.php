<?php namespace Tectonic\Shift\Modules\Authentication\Models;

use Tectonic\Application\Eventing\EventGenerator;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Modules\Authentication\Events\TokenWasGenerated;

class Token extends Model
{
    use EventGenerator;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'tokens';

    /**
     * Fillable attributes
     *
     * @var array
     */
    public $fillable = ['account_id', 'from_id', 'user_id', 'token'];

    /**
     * Create an account switch token
     *
     * @param $accountId
     * @param $userId
     * @param $token
     *
     * @return static
     */
    public static function createToken($accountId, $fromId, $userId, $token)
    {
        $tokenRecord = new static;

        $tokenRecord->account_id = $accountId;
        $tokenRecord->from_id    = $fromId;
        $tokenRecord->user_id    = $userId;
        $tokenRecord->token      = $token;

        $tokenRecord->raise(new TokenWasGenerated($tokenRecord));

        return $tokenRecord;
    }

}