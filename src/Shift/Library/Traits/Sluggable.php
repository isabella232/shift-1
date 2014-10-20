<?php namespace Tectonic\Shift\Library\Traits;

use App;
use Tectonic\Shift\Library\Support\Slug;

trait Sluggable
{
    /**
     * @ORM\Column(type="string", name="`slug`")
     */
    protected $slug;

    /**
     * @ORM\PostPersist
     */
    public function postPersist()
    {
        $this->slug = (new Slug())->encode($this->id);

        // TODO: Save/persist slug. This method will only be called after initial record creation (not on updates).
        // Note: We must add the top level class annotation '@ORM\HasLifecycleCallbacks()' to any Entity classes
        //       that use this trait - just like we do when using the Timestamps or SoftDeletes trait.
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