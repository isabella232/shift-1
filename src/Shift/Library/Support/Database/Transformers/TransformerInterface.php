<?php
namespace Tectonic\Shift\Library\Support\Database\Transformers;

interface TransformerInterface
{
    /**
     * Determines whether a given entity is appropriate for this transformer.
     *
     * @param $resource
     * @return mixed
     */
    public function isAppropriate($resource);

    /**
     * Decorates a given entity.
     *
     * @param $resource
     * @return mixed
     */
    public function transform($resource);
}
