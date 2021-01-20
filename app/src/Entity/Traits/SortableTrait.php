<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait SortableTrait
{
    /**
     * @Gedmo\SortablePosition()
     * @ORM\Column(name="position", type="integer", options={"default": "0"})
     */
    private $position;

    /**
     * @return mixed
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     * @return SortableTrait
     */
    public function setPosition($position): self
    {
        $this->position = $position;
        return $this;
    }


}