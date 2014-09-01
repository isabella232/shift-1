<?php namespace Tectonic\Shift\Library\Support;

use Orchestra\Asset\Factory;

class Asset extends Factory
{
    public function containers($excludes = [])
    {
        $containers = $this->containers;

        foreach($excludes as $exclude)
        {
            if(isset($containers[$exclude])) unset($containers[$exclude]);
        }

        return $containers;
    }
}
