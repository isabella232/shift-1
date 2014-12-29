<?php namespace Tectonic\Shift\Modules\Authentication\Models;

use Tectonic\Application\Eventing\EventGenerator;
use Tectonic\Shift\Library\Support\Database\Eloquent\Model;
use Tectonic\Shift\Library\Tokens\TokenGeneratorInterface;
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
    public $fillable = ['token', 'data'];

    /**
     * Create an account switch token
     *
     * @param \Tectonic\Shift\Library\Tokens\TokenGeneratorInterface $tokenGenerator
     *
     * @return static
     */
    public static function createToken(TokenGeneratorInterface $tokenGenerator)
    {
        $token = new static;

        $token->token = $tokenGenerator->generateToken();
        $token->data  = $tokenGenerator->encodeData();

        $token->raise(new TokenWasGenerated($token));

        return $token;
    }

}