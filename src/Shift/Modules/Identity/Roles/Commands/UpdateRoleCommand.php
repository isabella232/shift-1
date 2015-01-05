<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\Command;

class UpdateRoleCommand extends Command
{
    /**
     * Stores the slug string.
     *
     * @var string
     */
    public $slug;

    /**
     * Array of translated fields and their language codes.
     *
     * @var array
     */
    public $translated;

    /**
     * Whether the role is the default role for registrations or not.
     *
     * @var boolean
     */
    public $default;

    /**
     * Stores the permissions submitted by the form.
     *
     * @var array
     */
    public $permissions;

    /**
     * @param string $slug
     * @param array $translated
     */
    public function __construct($slug, $default, $translated, $permissions)
    {
        $this->slug = $slug;
        $this->default = $default;
        $this->translated = $translated;
        $this->permissions = $permissions;
    }

    /**
     * Create a new command instance with the slug and input array
     *
     * @param array $input
     * @return static
     */
    public static function withInput($input)
    {
        return new static($input['slug'], array_get($input, 'default', false), $input['translated'], $input['permission']);
    }
}
