<?php
namespace Tectonic\Shift\Modules\Identity\Roles\ValueObjects;

use Assert\Assertion;

class Mode
{
    /**
     * Determines whether or not the value object represents a permissable state.
     *
     * @var bool|null
     */
    private $mode;

    /**
     * True if permitted, false if denied - null for inherit permission values.
     *
     * @param bool|null $mode
     */
    public function __construct($mode)
    {
        Assertion::inArray($mode, ['allow', 'deny', 'inherit']);

        $this->mode = $mode;
    }

    /**
     * Returns the permitted value as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->mode;
    }
}
