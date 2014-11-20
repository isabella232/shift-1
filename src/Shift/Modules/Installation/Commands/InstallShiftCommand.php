<?php
namespace Tectonic\Shift\Modules\Installation\Commands;

use Tectonic\Application\Commanding\Command;

class InstallShiftCommand extends Command
{
    public $name;
    public $host;
    public $language;
    public $email;
    public $password;

    function __construct($name, $host, $language, $email, $password)
    {
        $this->name = $name;
        $this->host = $host;
        $this->email = $email;
        $this->password = $password;
        $this->language = $language;
    }
}
