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
	 * Returns positions among different entities
	 * @return mixed
	 */
    public function getPositions();

	/**
	 * Sets positions among different entities
	 * @return mixed
	 */
    public function setPositions();

	/**
	 * Returns current entity name over __toString() method
	 * @return mixed
	 */
    public function getName();
}
