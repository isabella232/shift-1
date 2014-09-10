<?php namespace Tectonic\Shift\Library\Traits;

use App;
use Tectonic\Shift\Library\Support\Slug;

trait Slugs
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
        $this->slug = (new Slug())->encode($this->id);

        // TODO: Save/persist slug. This method will only be called after initial record creation (not on updates).
        $entityManager = App::make('Doctrine\ORM\EntityManagerInterface');
        $entityManager->persist($this);
        $entityManager->flush();
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