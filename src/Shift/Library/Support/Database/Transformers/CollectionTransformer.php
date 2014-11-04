<?php
namespace Tectonic\Shift\Library\Support\Database\Transformers;

use IteratorAggregate;

class CollectionTransformer extends BaseTransformer implements TransformerInterface
{
    /**
     * Determines whether a given entity is appropriate for this transformer.
     *
     * @param $resource
     * @return mixed
     */
    public function isAppropriate($resource)
    {
        return is_array($resource) or $resource instanceof IteratorAggregate;
    }

    /**
     * Decorates a given entity.
     *
     * @param $resource
     * @return mixed
     */
    public function transform($resource)
    {
        foreach ($resource as $entity) {

        }
    }
}
 