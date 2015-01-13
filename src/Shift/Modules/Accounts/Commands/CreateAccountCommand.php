<?php
namespace Tectonic\Shift\Modules\Accounts\Commands;

use Tectonic\Application\Commanding\Command;

class CreateAccountCommand extends Command
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $defaultLanguageCode;

    /**
     * @var string
     */
    public $domain;

    /**
     * @param array $translated
     */
    public function __construct($name, $defaultLanguageCode, $domain)
    {
        $this->name = $name;
        $this->defaultLanguageCode = $defaultLanguageCode;
        $this->domain = $domain;
    }

    /**
     * @param array $input
     * @return CreateAccountCommand
     */
    public static function fromInput(array $input)
    {
        return new self($input['name'], $input['defaultLanguageCode'], $input['domain']);
    }
}
