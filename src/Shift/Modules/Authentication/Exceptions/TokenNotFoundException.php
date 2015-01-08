<?php namespace Tectonic\Shift\Modules\Authentication\Exceptions; 

class TokenNotFoundException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'The account switch token was not found.';
}