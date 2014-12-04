<?php
namespace Tectonic\Shift\Modules\Identity\Users\Commands;

use Tectonic\Application\Commanding\Command;

class UpdateUserProfileCommand extends Command
{
    /**
     * @var int
     */
    public $userId;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $passwordConfirmation;

    /**
     * @param int    $userId
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     */
    public function __construct($userId, $firstName, $lastName, $email, $password, $passwordConfirmation)
    {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }
} 