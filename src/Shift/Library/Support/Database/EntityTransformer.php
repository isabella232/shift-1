<?php
namespace Tectonic\Shift\Library\Support\Database;

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
     * Works through an array of elements and transforms each one.
     *
     * @param array $collection
     */
    public function collection(array $collection)
    {
        foreach ($collection as $entity) {
            $this->transform($entity);
        }
    }

    /**
     * Transforms a single entity based on the transformers available.
     *
     * @param $entity
     */
    public function entity($entity)
    {
        $this->transform($entity);
    }

    /**
     * Transforms an entity, if a given transformer is appropriate for the job.
     *
     * @param $entity
     */
    protected function transform($entity)
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->isAppropriate($entity)) {
                $transformer->decorate($entity);
            }
        }
    }
}
 