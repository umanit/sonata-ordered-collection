<?php

namespace Umanit\Bundle\SonataOrderedCollectionBundle\Model;

interface OrderableInterface
{
    /**
     * Sets the position of the element in a collection.
     *
     * @param int $position
     */
    public function setPosition($position);

    /**
     * Returns the position of the element in a collection.
     *
     * @return int
     */
    public function getPosition();

	/**
	 * Returns current entity name over __toString() method
	 * @return mixed
	 */
    public function getName();
}
