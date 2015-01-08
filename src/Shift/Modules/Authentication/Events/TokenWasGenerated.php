<?php namespace Tectonic\Shift\Modules\Authentication\Events;

use Tectonic\Application\Eventing\Event;
use Tectonic\Shift\Modules\Authentication\Models\Token;

class TokenWasGenerated extends Event
{
    /**
     * @var \Tectonic\Shift\Modules\Authentication\Models\Token
     */
    public $token;

    /**
     * @param \Tectonic\Shift\Modules\Authentication\Models\Token $token
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }
}