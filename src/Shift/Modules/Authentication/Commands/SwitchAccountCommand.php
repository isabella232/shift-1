<?php namespace Tectonic\Shift\Modules\Authentication\Commands; 

use Tectonic\Application\Commanding\Command;

class SwitchAccountCommand extends Command
{

    /**
     * @var string
     */
    public $token;

    /**
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }
}