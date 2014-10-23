<?php
namespace Tectonic\Shift\Library\Support\Database;

use Tectonic\Shift\Library\Support\Database\Transformers\TransformerInterface;

class EntityTransformer
{
    /**
     * Contains an array of transformers to be applied to a given collection
     * or entity that is handled to the transformer.
     *
     * @var array|TransformerInterface
     */
    private $transformers = [];

    /**
     * @param TransformerInterface $transformers
     */
    public function __construct(TransformerInterface ...$transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * Transforms a resource. A resource can be an entity, or a collection of entities. Transformers
     * will then notify the EntityTransformer as to whether or not they're suitable for the job.
     *
     * @param $resource
     */
    public function transform($resource)
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->isAppropriate($resource)) {
                $transformer->decorate($resource);
            }
        }
    }
}
 