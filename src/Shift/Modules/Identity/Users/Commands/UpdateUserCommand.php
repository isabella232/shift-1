<?php
namespace Tectonic\Shift\Modules\Identity\Users\Commands;

use Tectonic\Application\Commanding\Command;

class UpdateUserCommand extends Command
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $passwordConfirmation;
    public $slug;

    public function __construct($slug, $firstName, $lastName, $email, $password, $passwordConfirmation)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
        $this->slug = $slug;
    }

    /**
     * Instantiates the command based on an array of input.
     *
     * @param array $input
     * @return CreateUserCommand
     */
    public static function fromInput(array $input)
    {
        return new self($input['slug'], $input['firstName'], $input['lastName'], $input['email'], $input['password'], $input['passwordConfirmation']);
    }
}
