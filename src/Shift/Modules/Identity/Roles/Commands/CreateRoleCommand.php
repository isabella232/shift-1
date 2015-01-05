<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\Command;

class CreateRoleCommand extends Command
{
    /**
     * @var array
     */
    public $translated;

    /**
     * @var
     */
    public $default;

    /**
     * @var array
     */
    public $permissions;

    /**
     * @param array $translated
     */
    public function __construct($default, array $translated, array $permissions)
    {
        $this->translated = $translated;
        $this->default = $default;
        $this->permissions = $permissions;
    }

    /**
     * Create a new command instance based on user input.
     *
     * @param array $input
     * @return static
     */
    public static function withInput(array $input)
    {
        return new static(array_get($input, 'default', false), $input['translated'], $input['permission']);
    }
}
