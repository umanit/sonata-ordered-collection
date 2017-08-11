<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Model;

use Doctrine\ORM\Mapping as ORM;

trait OrderableTrait
{
    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    protected $position;

    /**
     * Sets the position of the element in a collection.
     *
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Returns the position of the element in a collection.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }
}
