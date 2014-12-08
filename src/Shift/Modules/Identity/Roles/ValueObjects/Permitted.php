<?php
namespace Tectonic\Shift\Modules\Identity\Roles\ValueObjects;

use InvalidArgumentException;

class Permitted
{
    /**
     * Determines whether or not the value object represents a permissable state.
     *
     * @var bool|null
     */
    private $permitted;

    /**
     * True if permitted, false if denied - null for inherit permission values.
     *
     * @param bool|null $permitted
     */
    public function __construct($permitted)
    {
        if (!in_array($permitted, [true, false, null])) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid $permitted value.'));
        }

        $this->permitted = $permitted;
    }

    /**
     * Returns the permitted value as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->permitted;
    }
}
 