<?php
namespace Tectonic\Shift\Modules\Localisation\Support;

class ResourceCriteria
{
    /**
     * Stores the resources and their affiliated IDs for searching.
     *
     * @var array
     */
    private $resources = [];

    public function addResource($resource)
    {
        if (!isset($this->resources[$resource])) {
            $this->resources[$resource] = [];
        }
    }

    public function addId($resource, $id)
    {
        $this->resources[$resource][] = $id;
    }

    public function getResources()
    {
        return array_keys($this->resources);
    }

    public function getIds($resource)
    {
        return $this->resources[$resource];
    }
}
 