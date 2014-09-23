<?php namespace Tectonic\Shift\Library\Support;

use Orchestra\Asset\Factory;

class AssetFactory extends Factory
{
    public function containers($excludes = [])
    {
        $containers = $this->containers;
        
        return array_diff_key($containers, $excludes);
    }
}
