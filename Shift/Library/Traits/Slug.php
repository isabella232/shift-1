<?php namespace Tectonic\Shift\Library\Traits;

use Tectonic\Shift\Library\Support\Slug as SlugCreator;

trait Slug
{
    /**
     * @ORM\Column(type="string")
     */
    private $slug;

    /**
     * @ORM\PostPersist
     */
    public function postPersist()
    {
        $this->slug = (new SlugCreator())->encode($this->id);

        // TODO: Save/persist slug. This postPersist() method will only be called after initial record creation.
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
}