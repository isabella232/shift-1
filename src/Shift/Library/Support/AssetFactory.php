<?php namespace Tectonic\Shift\Library\Support;

use Orchestra\Asset\Factory;

class AssetFactory extends Factory
{
    public function containers($excludes = [])
    {
        $containers = $this->containers;

        if (!$excludes) {
            return $containers;
        }

        foreach ($excludes as $exclude) {
            if (isset($containers[$exclude])) {
                unset($containers[$exclude]);
            }
        }

        return $containers;
    }
}
